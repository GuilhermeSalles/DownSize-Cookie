import React from "react";
import { Head, usePage } from "@inertiajs/react";
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
import { Menu, LogOut } from "lucide-react";
import { PageProps } from "@/types";

type AdminUser = {
    id: number;
    name: string;
    email: string;
    role: "user" | "admin" | "superadmin";
    profile_image?: string | null;
};

type SharedProps = {
    admin?: AdminUser | null;
    csrfToken?: string;
};

export default function Dashboard() {
    const { props } =
        usePage<PageProps<{ admin?: AdminUser; csrfToken?: string }>>();

    const admin = (props as SharedProps).admin || null;
    const csrf =
        (props as SharedProps).csrfToken || (window as any).Laravel?.csrfToken;

    const [tab, setTab] = React.useState<string>("products");

    const initials = React.useMemo(() => {
        if (!admin?.name) return "U";
        const parts = admin.name.trim().split(" ");
        if (parts.length === 1) return parts[0].charAt(0).toUpperCase();
        return (
            parts[0].charAt(0) + parts[parts.length - 1].charAt(0)
        ).toUpperCase();
    }, [admin?.name]);

    return (
        <>
            <Head title="Admin • Cookieland" />

            {/* Tabs PRECISA envolver tudo que usa TabsList/Trigger/Content */}
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
                            {/* Navegação de abas no desktop */}
                            <TabsList className="hidden md:inline-flex">
                                <TabsTrigger value="products">
                                    Products
                                </TabsTrigger>
                                <TabsTrigger value="orders">Orders</TabsTrigger>
                                <TabsTrigger value="addons">
                                    Add-ons
                                </TabsTrigger>
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

                            {/* Navegação mobile via Sheet */}
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
                                        <Button
                                            variant={
                                                tab === "addons"
                                                    ? "default"
                                                    : "secondary"
                                            }
                                            onClick={() => setTab("addons")}
                                        >
                                            Add-ons
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
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <h2 className="text-lg font-medium">
                                    Manage Products
                                </h2>
                                <Button>Create Product</Button>
                            </div>
                            <div className="text-sm text-neutral-600">
                                Product grid and editing will be implemented
                                next.
                            </div>
                        </div>
                    </TabsContent>

                    <TabsContent value="orders" className="mt-0">
                        <div className="grid gap-4">
                            <h2 className="text-lg font-medium">Orders</h2>
                            <div className="text-sm text-neutral-600">
                                Orders per status with accordion will be
                                implemented next.
                            </div>
                        </div>
                    </TabsContent>

                    <TabsContent value="addons" className="mt-0">
                        <div className="grid gap-4">
                            <h2 className="text-lg font-medium">Add-ons</h2>
                            <div className="text-sm text-neutral-600">
                                Add-ons management will be implemented next.
                            </div>
                        </div>
                    </TabsContent>
                </main>
            </Tabs>
        </>
    );
}
