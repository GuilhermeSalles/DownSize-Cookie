import React from "react";
import { Head, useForm, usePage } from "@inertiajs/react";
import { Tabs, TabsList, TabsTrigger, TabsContent } from "@/components/ui/tabs";
import { Button } from "@/components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/components/ui/sheet";
import { Separator } from "@/components/ui/separator";
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Badge } from "@/components/ui/badge";
import { Menu, LogOut, Pencil } from "lucide-react";
import { PageProps } from "@/types";

type AdminUser = {
    id: number;
    name: string;
    email: string;
    role: "user" | "admin" | "superadmin";
    profile_image?: string | null;
};

type Product = {
    id: number;
    name: string;
    description?: string | null;
    image_path?: string | null;
    price: string | number;
    category: "cookie" | "sandwich" | "drink" | "addon" | "other";
    active: boolean;
    created_at: string;
    updated_at: string;
};

type SharedProps = {
    admin?: AdminUser | null;
    csrfToken?: string;
    products: Product[];
    can: {
        create: boolean;
        edit_image: boolean;
    };
};

type FilterType = "all" | "cookie" | "sandwich" | "drink";

export default function Dashboard() {
    const { props } = usePage<PageProps<SharedProps>>();
    const admin = props.admin || null;
    const products = props.products || [];
    const can = props.can || { create: false, edit_image: false };

    const csrf = (props as any).csrfToken || (window as any).Laravel?.csrfToken;

    // Tabs principais: products / orders
    const [tab, setTab] = React.useState<string>("products");

    // Filtro local por categoria
    const [filter, setFilter] = React.useState<FilterType>("all");
    const filtered = React.useMemo(() => {
        if (filter === "all") return products;
        return products.filter((p) => p.category === filter);
    }, [products, filter]);

    const initials = React.useMemo(() => {
        if (!admin?.name) return "U";
        const parts = admin.name.trim().split(" ");
        if (parts.length === 1) return parts[0].charAt(0).toUpperCase();
        return (
            parts[0].charAt(0) + parts[parts.length - 1].charAt(0)
        ).toUpperCase();
    }, [admin?.name]);

    // ---------- Modal de Edição ----------
    const [editOpen, setEditOpen] = React.useState(false);
    const [current, setCurrent] = React.useState<Product | null>(null);

    const { data, setData, patch, processing, reset } = useForm<
        Partial<Product>
    >({
        name: "",
        description: "",
        price: "",
        category: "cookie",
        image_path: "",
        active: true,
    });

    function openEdit(p: Product) {
        setCurrent(p);
        setData({
            name: p.name,
            description: p.description || "",
            price: p.price,
            category: p.category,
            image_path: p.image_path || "",
            active: !!p.active,
        });
        setEditOpen(true);
    }

    function onCloseEdit() {
        setEditOpen(false);
        setCurrent(null);
        reset();
    }

    function submitEdit(e: React.FormEvent) {
        e.preventDefault();
        if (!current) return;

        patch(`/admin/products/${current.id}`, {
            preserveScroll: true,
            onSuccess: () => onCloseEdit(),
        });
    }

    function categoryLabel(cat: Product["category"]) {
        const map: Record<Product["category"], string> = {
            cookie: "Cookie",
            sandwich: "Sandwich",
            drink: "Drink",
            addon: "Add-on",
            other: "Other",
        };
        return map[cat] ?? cat;
    }

    return (
        <>
            <Head title="Admin • Cookieland" />

            <Tabs
                value={tab}
                onValueChange={setTab}
                className="min-h-screen bg-white"
            >
                {/* HEADER */}
                <header className="border-b">
                    <div className="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
                        <h1 className="text-xl font-semibold">
                            Cookieland Admin
                        </h1>

                        <div className="flex items-center gap-3">
                            {/* Abas (desktop) — sem Add-ons */}
                            <TabsList className="hidden md:inline-flex">
                                <TabsTrigger value="products">
                                    Products
                                </TabsTrigger>
                                <TabsTrigger value="orders">Orders</TabsTrigger>
                            </TabsList>

                            {/* Perfil + menu */}
                            <DropdownMenu>
                                <DropdownMenuTrigger className="outline-none">
                                    <div className="flex items-center gap-2">
                                        <Avatar className="h-8 w-8">
                                            <AvatarImage
                                                src={
                                                    admin?.profile_image ||
                                                    undefined
                                                }
                                            />
                                            <AvatarFallback>
                                                {initials}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div className="hidden sm:flex flex-col items-start leading-tight">
                                            <span className="text-sm font-medium">
                                                {admin?.name || "User"}
                                            </span>
                                            <span className="text-[11px] text-neutral-500 capitalize">
                                                {admin?.role || "user"}
                                            </span>
                                        </div>
                                    </div>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    align="end"
                                    className="w-56"
                                >
                                    <DropdownMenuLabel className="flex flex-col">
                                        <span className="text-sm">
                                            {admin?.name || "User"}
                                        </span>
                                        <span className="text-xs text-neutral-500">
                                            {admin?.email || ""}
                                        </span>
                                    </DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem asChild>
                                        <a href="/" className="w-full">
                                            Back to site
                                        </a>
                                    </DropdownMenuItem>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem asChild>
                                        <form
                                            method="post"
                                            action="/admin/logout"
                                            className="w-full"
                                        >
                                            <input
                                                type="hidden"
                                                name="_token"
                                                value={csrf}
                                            />
                                            <button
                                                type="submit"
                                                className="w-full flex items-center gap-2"
                                            >
                                                <LogOut className="h-4 w-4" />
                                                <span>Sign out</span>
                                            </button>
                                        </form>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>

                            {/* Mobile menu */}
                            <Sheet>
                                <SheetTrigger className="md:hidden inline-flex p-2 rounded-md border">
                                    <Menu className="h-5 w-5" />
                                </SheetTrigger>
                                <SheetContent side="right" className="w-80">
                                    <SheetHeader>
                                        <SheetTitle>
                                            Cookieland Admin
                                        </SheetTitle>
                                    </SheetHeader>
                                    <Separator className="my-4" />
                                    <div className="grid gap-2">
                                        <Button
                                            variant={
                                                tab === "products"
                                                    ? "default"
                                                    : "secondary"
                                            }
                                            onClick={() => setTab("products")}
                                        >
                                            Products
                                        </Button>
                                        <Button
                                            variant={
                                                tab === "orders"
                                                    ? "default"
                                                    : "secondary"
                                            }
                                            onClick={() => setTab("orders")}
                                        >
                                            Orders
                                        </Button>
                                        <Separator className="my-2" />
                                        <form
                                            method="post"
                                            action="/admin/logout"
                                        >
                                            <input
                                                type="hidden"
                                                name="_token"
                                                value={csrf}
                                            />
                                            <Button
                                                variant="outline"
                                                className="w-full"
                                            >
                                                <LogOut className="h-4 w-4 mr-2" />
                                                Sign out
                                            </Button>
                                        </form>
                                    </div>
                                </SheetContent>
                            </Sheet>
                        </div>
                    </div>
                </header>

                {/* MAIN */}
                <main className="max-w-6xl mx-auto px-4 py-6 w-full">
                    <TabsContent value="products" className="mt-0">
                        <div className="grid gap-4">
                            {/* Título + criar */}
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <h2 className="text-lg font-medium">
                                    Manage Products
                                </h2>
                                {can.create && (
                                    <Button /* onClick={() => ...} */>
                                        Create Product
                                    </Button>
                                )}
                            </div>

                            {/* Filtro */}
                            <div className="flex flex-wrap items-center gap-2">
                                <span className="text-sm text-neutral-600 mr-2">
                                    Filter:
                                </span>
                                <Button
                                    size="sm"
                                    variant={
                                        filter === "all"
                                            ? "default"
                                            : "secondary"
                                    }
                                    onClick={() => setFilter("all")}
                                >
                                    All
                                </Button>
                                <Button
                                    size="sm"
                                    variant={
                                        filter === "cookie"
                                            ? "default"
                                            : "secondary"
                                    }
                                    onClick={() => setFilter("cookie")}
                                >
                                    Cookies
                                </Button>
                                <Button
                                    size="sm"
                                    variant={
                                        filter === "sandwich"
                                            ? "default"
                                            : "secondary"
                                    }
                                    onClick={() => setFilter("sandwich")}
                                >
                                    Sandwiches
                                </Button>
                                <Button
                                    size="sm"
                                    variant={
                                        filter === "drink"
                                            ? "default"
                                            : "secondary"
                                    }
                                    onClick={() => setFilter("drink")}
                                >
                                    Drinks
                                </Button>
                            </div>

                            {/* GRID responsivo de produtos (filtrado) */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {filtered.map((p) => (
                                    <div
                                        key={p.id}
                                        className="border rounded-lg p-3 flex flex-col gap-2"
                                    >
                                        <div className="flex items-center justify-between">
                                            <Badge variant="outline">
                                                {categoryLabel(p.category)}
                                            </Badge>
                                            <Badge
                                                className={
                                                    p.active
                                                        ? ""
                                                        : "bg-neutral-400"
                                                }
                                            >
                                                {p.active
                                                    ? "Active"
                                                    : "Inactive"}
                                            </Badge>
                                        </div>

                                        {p.image_path && (
                                            <div className="mt-2">
                                                <img
                                                    src={`/${p.image_path}`}
                                                    alt={p.name}
                                                    className="w-full h-36 object-cover rounded-md border"
                                                    loading="lazy"
                                                />
                                            </div>
                                        )}

                                        <div className="mt-1">
                                            <div className="font-medium">
                                                {p.name}
                                            </div>
                                            <div className="text-sm text-neutral-600 line-clamp-3">
                                                {p.description}
                                            </div>
                                        </div>

                                        <div className="text-sm">
                                            <span className="font-semibold">
                                                £{Number(p.price).toFixed(2)}
                                            </span>
                                        </div>

                                        <div className="mt-auto flex items-center justify-between">
                                            <Button
                                                variant="secondary"
                                                size="sm"
                                                onClick={() => openEdit(p)}
                                            >
                                                <Pencil className="h-4 w-4 mr-2" />
                                                Edit
                                            </Button>
                                            {p.image_path && (
                                                <a
                                                    href={`/${p.image_path}`}
                                                    target="_blank"
                                                    className="text-xs underline text-neutral-500"
                                                >
                                                    Image
                                                </a>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </TabsContent>

                    <TabsContent value="orders" className="mt-0">
                        <div className="grid gap-4">
                            <h2 className="text-lg font-medium">Orders</h2>
                            <div className="text-sm text-neutral-600">
                                Orders per status com accordion — em breve.
                            </div>
                        </div>
                    </TabsContent>
                </main>
            </Tabs>

            {/* MODAL: Editar Produto */}
            <Dialog open={editOpen} onOpenChange={setEditOpen}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Edit product</DialogTitle>
                    </DialogHeader>

                    <form onSubmit={submitEdit} className="grid gap-4">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>
                            <Input
                                id="name"
                                value={data.name ?? ""}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="price">Price (£)</Label>
                            <Input
                                id="price"
                                type="number"
                                step="0.01"
                                min="0"
                                value={String(data.price ?? "")}
                                onChange={(e) =>
                                    setData("price", e.target.value)
                                }
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="description">Description</Label>
                            <Textarea
                                id="description"
                                rows={4}
                                value={data.description ?? ""}
                                onChange={(e) =>
                                    setData("description", e.target.value)
                                }
                            />
                        </div>

                        {/* Campos só para superadmin */}
                        {can.edit_image && (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="image_path">
                                        Image path
                                    </Label>
                                    <Input
                                        id="image_path"
                                        placeholder="ex.: assets/img/cookie-oreo.jpg"
                                        value={data.image_path ?? ""}
                                        onChange={(e) =>
                                            setData(
                                                "image_path",
                                                e.target.value
                                            )
                                        }
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="category">Category</Label>
                                    <select
                                        id="category"
                                        className="border rounded-md h-9 px-3 text-sm"
                                        value={data.category ?? "cookie"}
                                        onChange={(e) =>
                                            setData(
                                                "category",
                                                e.target.value as any
                                            )
                                        }
                                    >
                                        <option value="cookie">Cookie</option>
                                        <option value="sandwich">
                                            Sandwich
                                        </option>
                                        <option value="drink">Drink</option>
                                        <option value="addon">Add-on</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </>
                        )}

                        <div className="grid gap-2">
                            <Label htmlFor="active">Status</Label>
                            <select
                                id="active"
                                className="border rounded-md h-9 px-3 text-sm"
                                value={data.active ? "1" : "0"}
                                onChange={(e) =>
                                    setData("active", e.target.value === "1")
                                }
                            >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <DialogFooter>
                            <Button
                                type="button"
                                variant="secondary"
                                onClick={onCloseEdit}
                            >
                                Cancel
                            </Button>
                            <Button type="submit" disabled={processing}>
                                Save
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </>
    );
}
