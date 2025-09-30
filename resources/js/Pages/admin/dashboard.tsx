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
import { Menu, LogOut, Pencil, Plus, Eye } from "lucide-react";
import { PageProps } from "@/types";

// Recharts
import {
    AreaChart,
    Area,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    ResponsiveContainer,
    BarChart,
    Bar,
    Legend,
} from "recharts";

/* =========================
 * Types
 * =======================*/
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

type OrderItem = {
    id: number;
    product_id: number;
    product_name: string;
    unit_price: string | number;
    quantity: number;
    line_total: string | number;
    item_note?: string | null;
};

type OrderStatus =
    | "pending"
    | "confirmed"
    | "preparing"
    | "ready"
    | "completed"
    | "cancelled";

type Order = {
    id: number;
    customer_name: string;
    customer_address: string;
    service_type: "Pick-up" | "Delivery";
    delivery_city_text?: string | null;
    delivery_fee?: string | number | null;
    delivery_day?: "Friday" | "Saturday" | null;
    delivery_time?: string | null;
    pickup_day?: "Friday" | "Saturday" | null;
    pickup_time?: string | null;
    payment_method: "Bank Transfer" | "Cash";
    customer_observation?: string | null;
    addon_observation?: string | null;
    subtotal: string | number;
    addons_total: string | number;
    delivery_total: string | number;
    total: string | number;
    status: OrderStatus;
    created_at: string;
    items: OrderItem[];
};

type SharedProps = {
    admin?: AdminUser | null;
    csrfToken?: string;
    products: Product[];
    can: { create: boolean; edit_image: boolean };
};

type FilterType = "all" | "cookie" | "sandwich" | "drink";
type OrderStatusFilter = "all" | OrderStatus;

/* =========================
 * Component
 * =======================*/
export default function Dashboard() {
    // Tipagem segura dos props do Inertia
    const { props } = usePage() as unknown as {
        props: PageProps & SharedProps;
    };

    const admin = (props.admin ?? null) as AdminUser | null;
    const products = (props.products ?? []) as Product[];
    const can = (props.can ?? { create: false, edit_image: false }) as {
        create: boolean;
        edit_image: boolean;
    };
    const csrf =
        (props.csrfToken as string | undefined) ||
        ((window as any).Laravel?.csrfToken as string | undefined) ||
        "";

    // ORDERS como primeira aba
    const [tab, setTab] = React.useState<string>("orders");

    // Avatar iniciais
    const initials = React.useMemo(() => {
        if (!admin?.name) return "U";
        const parts = admin.name.trim().split(" ");
        if (parts.length === 1) return parts[0].charAt(0).toUpperCase();
        return (
            parts[0].charAt(0) + parts[parts.length - 1].charAt(0)
        ).toUpperCase();
    }, [admin?.name]);

    /* ========= OVERVIEW (metrics) ========= */
    const [ordersByStatus, setOrdersByStatus] = React.useState<
        Record<string, number>
    >({});
    const [productsByCategory, setProductsByCategory] = React.useState<
        Record<string, number>
    >({});
    const [ordersLast7Days, setOrdersLast7Days] = React.useState<
        { date: string; qty: number }[]
    >([]);

    React.useEffect(() => {
        fetch("/admin/metrics", {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        })
            .then((r) => r.json())
            .then((d) => {
                setOrdersByStatus(d.ordersByStatus || {});
                setProductsByCategory(d.productsByCategory || {});
                setOrdersLast7Days(d.ordersLast7Days || []);
            })
            .catch(() => {});
    }, []);

    const statusData = React.useMemo(
        () =>
            Object.entries(ordersByStatus).map(([status, qty]) => ({
                status,
                qty,
            })),
        [ordersByStatus]
    );

    const categoryData = React.useMemo(
        () =>
            Object.entries(productsByCategory).map(([category, qty]) => ({
                category,
                qty,
            })),
        [productsByCategory]
    );

    /* ========= PRODUCTS ========= */
    const [filter, setFilter] = React.useState<FilterType>("all");
    const filteredProducts = React.useMemo(() => {
        if (filter === "all") return products;
        return products.filter((p) => p.category === filter);
    }, [products, filter]);

    const [editOpen, setEditOpen] = React.useState(false);
    const [current, setCurrent] = React.useState<Product | null>(null);

    const { data, setData, patch, post, processing, reset } = useForm<
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

    function openCreate() {
        setCurrent(null);
        setData({
            name: "",
            description: "",
            price: "",
            category: "cookie",
            image_path: "",
            active: true,
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

    function submitCreate(e: React.FormEvent) {
        e.preventDefault();
        post(`/admin/products`, {
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
    /* ========= UI helpers (status colors pastel) ========= */
    type StatusUI = {
        pill: string; // bg + text + ring
        dot: string; // bolinha
        label: string; // texto humanizado
    };
    const STATUS_UI: Record<OrderStatus, StatusUI> = {
        pending: {
            pill: "bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200",
            dot: "bg-amber-500/70",
            label: "Pending",
        },
        confirmed: {
            pill: "bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-200",
            dot: "bg-sky-500/70",
            label: "Confirmed",
        },
        preparing: {
            pill: "bg-violet-50 text-violet-700 ring-1 ring-inset ring-violet-200",
            dot: "bg-violet-500/70",
            label: "Preparing",
        },
        ready: {
            pill: "bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-200",
            dot: "bg-indigo-500/70",
            label: "Ready",
        },
        completed: {
            pill: "bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200",
            dot: "bg-emerald-500/70",
            label: "Completed",
        },
        cancelled: {
            pill: "bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200",
            dot: "bg-rose-500/70",
            label: "Cancelled",
        },
    };

    function StatusPill({ status }: { status: OrderStatus }) {
        const ui = STATUS_UI[status];
        return (
            <span
                className={`inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-medium ${ui.pill}`}
            >
                <span className={`h-2 w-2 rounded-full ${ui.dot}`} />
                {ui.label}
            </span>
        );
    }

    /* ========= ORDERS ========= */
    const [orders, setOrders] = React.useState<Order[]>([]);
    const [orderFilter, setOrderFilter] =
        React.useState<OrderStatusFilter>("pending");
    const [orderModalOpen, setOrderModalOpen] = React.useState(false);
    const [selectedOrder, setSelectedOrder] = React.useState<Order | null>(
        null
    );

    const orderStatuses: OrderStatusFilter[] = [
        "all",
        "pending",
        "confirmed",
        "preparing",
        "ready",
        "completed",
        "cancelled",
    ];

    function loadOrders(status: OrderStatusFilter) {
        const qs =
            status === "all" ? "" : `?status=${encodeURIComponent(status)}`;
        fetch(`/admin/orders${qs}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        })
            .then((r) => r.json())
            .then((d) => setOrders(d.orders || []))
            .catch(() => {});
    }

    React.useEffect(() => {
        loadOrders(orderFilter);
    }, [orderFilter]);

    function openOrder(o: Order) {
        setSelectedOrder(o);
        setOrderModalOpen(true);
    }

    async function updateOrderStatus(order: Order, nextStatus: OrderStatus) {
        await fetch(`/admin/orders/${order.id}/status`, {
            method: "PATCH",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
            },
            body: JSON.stringify({ status: nextStatus }),
        });
        loadOrders(orderFilter);
        setOrderModalOpen(false);
    }

    function formatMoney(n: number | string | null | undefined) {
        const v = Number(n || 0);
        return `£${v.toFixed(2)}`;
    }

    function nextSteps(s: OrderStatus): OrderStatus[] {
        switch (s) {
            case "pending":
                return ["confirmed", "cancelled"];
            case "confirmed":
                return ["preparing", "cancelled"];
            case "preparing":
                return ["ready", "cancelled"];
            case "ready":
                return ["completed", "cancelled"];
            case "completed":
            case "cancelled":
                return [];
        }
    }

    return (
        <>
            <Head title="Admin • Cookieland">
                <link rel="icon" href="/assets/img/icon.png" />
                <meta
                    name="description"
                    content="Cookieland admin dashboard to manage products and track orders."
                />
                <meta property="og:title" content="Cookieland • Admin" />
                <meta
                    property="og:description"
                    content="Manage products and track orders at Cookieland."
                />
                <meta
                    property="og:image"
                    content="/assets/img/cookie-banner.jpg"
                />
                <meta property="og:type" content="website" />
            </Head>

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
                            {/* Abas desktop — Orders primeiro */}
                            <TabsList className="hidden md:inline-flex">
                                <TabsTrigger value="orders">Orders</TabsTrigger>
                                <TabsTrigger value="products">
                                    Products
                                </TabsTrigger>
                                <TabsTrigger value="overview">
                                    Overview
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

                            {/* Menu mobile */}
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
                                                tab === "overview"
                                                    ? "default"
                                                    : "secondary"
                                            }
                                            onClick={() => setTab("overview")}
                                        >
                                            Overview
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
                    {/* ORDERS */}
                    <TabsContent value="orders" className="mt-0">
                        <div className="grid gap-4">
                            <div className="flex items-center justify-between gap-3">
                                <h2 className="text-lg font-medium">Orders</h2>
                                <div className="flex flex-wrap gap-2">
                                    {orderStatuses.map((status) => (
                                        <Button
                                            key={status}
                                            size="sm"
                                            variant={
                                                orderFilter === status
                                                    ? "default"
                                                    : "secondary"
                                            }
                                            onClick={() =>
                                                setOrderFilter(status)
                                            }
                                        >
                                            {status[0].toUpperCase() +
                                                status.slice(1)}
                                        </Button>
                                    ))}
                                </div>
                            </div>

                            <div className="overflow-x-auto border rounded-lg">
                                <table className="min-w-full text-sm">
                                    <thead className="bg-neutral-50 text-neutral-700">
                                        <tr>
                                            <th className="text-left px-3 py-2">
                                                #
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Customer
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Type
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Payment
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Total
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Status
                                            </th>
                                            <th className="text-right px-3 py-2">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {orders.length === 0 && (
                                            <tr>
                                                <td
                                                    colSpan={7}
                                                    className="px-3 py-6 text-center text-neutral-500"
                                                >
                                                    No orders.
                                                </td>
                                            </tr>
                                        )}
                                        {orders.map((o) => (
                                            <tr key={o.id} className="border-t">
                                                <td className="px-3 py-2">
                                                    {o.id}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {o.customer_name}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {o.service_type}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {o.payment_method}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {formatMoney(o.total)}
                                                </td>
                                                <td className="px-3 py-2 capitalize">
                                                    <StatusPill
                                                        status={o.status}
                                                    />
                                                </td>
                                                <td className="px-3 py-2 text-right">
                                                    <Button
                                                        size="sm"
                                                        variant="ghost"
                                                        className="border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700"
                                                        onClick={() =>
                                                            openOrder(o)
                                                        }
                                                    >
                                                        <Eye className="h-4 w-4 mr-2" />
                                                        View
                                                    </Button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </TabsContent>

                    {/* PRODUCTS */}
                    <TabsContent value="products" className="mt-0">
                        <div className="grid gap-4">
                            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <h2 className="text-lg font-medium">
                                    Manage Products
                                </h2>
                                {can.create && (
                                    <Button onClick={openCreate}>
                                        <Plus className="h-4 w-4 mr-2" />
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

                            {/* GRID */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {filteredProducts.map((p) => (
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
                                                    rel="noreferrer"
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

                    {/* OVERVIEW */}
                    <TabsContent value="overview" className="mt-0">
                        <div className="grid gap-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div className="border rounded-lg p-4">
                                    <div className="mb-3 font-medium">
                                        Orders • last 7 days
                                    </div>
                                    <div className="h-64">
                                        <ResponsiveContainer
                                            width="100%"
                                            height="100%"
                                        >
                                            <AreaChart data={ordersLast7Days}>
                                                <defs>
                                                    <linearGradient
                                                        id="colorQty"
                                                        x1="0"
                                                        y1="0"
                                                        x2="0"
                                                        y2="1"
                                                    >
                                                        <stop
                                                            offset="5%"
                                                            stopColor="currentColor"
                                                            stopOpacity={0.3}
                                                        />
                                                        <stop
                                                            offset="95%"
                                                            stopColor="currentColor"
                                                            stopOpacity={0}
                                                        />
                                                    </linearGradient>
                                                </defs>
                                                <CartesianGrid strokeDasharray="3 3" />
                                                <XAxis dataKey="date" />
                                                <YAxis allowDecimals={false} />
                                                <Tooltip />
                                                <Area
                                                    type="monotone"
                                                    dataKey="qty"
                                                    stroke="currentColor"
                                                    fill="url(#colorQty)"
                                                />
                                            </AreaChart>
                                        </ResponsiveContainer>
                                    </div>
                                </div>

                                <div className="border rounded-lg p-4">
                                    <div className="mb-3 font-medium">
                                        Orders • by status
                                    </div>
                                    <div className="h-64">
                                        <ResponsiveContainer
                                            width="100%"
                                            height="100%"
                                        >
                                            <BarChart data={statusData}>
                                                <CartesianGrid strokeDasharray="3 3" />
                                                <XAxis dataKey="status" />
                                                <YAxis allowDecimals={false} />
                                                <Tooltip />
                                                <Legend />
                                                <Bar dataKey="qty" />
                                            </BarChart>
                                        </ResponsiveContainer>
                                    </div>
                                </div>
                            </div>

                            <div className="border rounded-lg p-4">
                                <div className="mb-3 font-medium">
                                    Products • by category
                                </div>
                                <div className="h-72">
                                    <ResponsiveContainer
                                        width="100%"
                                        height="100%"
                                    >
                                        <BarChart data={categoryData}>
                                            <CartesianGrid strokeDasharray="3 3" />
                                            <XAxis dataKey="category" />
                                            <YAxis allowDecimals={false} />
                                            <Tooltip />
                                            <Legend />
                                            <Bar dataKey="qty" />
                                        </BarChart>
                                    </ResponsiveContainer>
                                </div>
                            </div>
                        </div>
                    </TabsContent>
                </main>

                {/* Footer */}
                <footer className="border-t">
                    <div className="max-w-6xl mx-auto px-4 py-6 text-xs text-neutral-500">
                        © {new Date().getFullYear()} — Developed by{" "}
                        <span className="font-medium">Guilherme Baltazar</span>
                    </div>
                </footer>
            </Tabs>

            {/* MODAL: CREATE/EDIT PRODUCT */}
            <Dialog open={editOpen} onOpenChange={setEditOpen}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>
                            {current ? "Edit product" : "Create product"}
                        </DialogTitle>
                    </DialogHeader>

                    <form
                        onSubmit={current ? submitEdit : submitCreate}
                        className="grid gap-4"
                    >
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
                                                e.target
                                                    .value as Product["category"]
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
                                {current ? "Save" : "Create"}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            {/* MODAL: VIEW/UPDATE ORDER */}
            <Dialog open={orderModalOpen} onOpenChange={setOrderModalOpen}>
                <DialogContent className="max-w-2xl">
                    <DialogHeader>
                        <DialogTitle>Order #{selectedOrder?.id}</DialogTitle>
                    </DialogHeader>

                    {selectedOrder && (
                        <div className="grid gap-4">
                            <div className="grid md:grid-cols-2 gap-3">
                                <div>
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Customer:
                                        </span>{" "}
                                        {selectedOrder.customer_name}
                                    </div>
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Service:
                                        </span>{" "}
                                        {selectedOrder.service_type}
                                    </div>
                                    {selectedOrder.service_type ===
                                    "Delivery" ? (
                                        <>
                                            <div className="text-sm">
                                                <span className="font-medium">
                                                    Address:
                                                </span>{" "}
                                                {selectedOrder.customer_address}
                                            </div>
                                            <div className="text-sm">
                                                <span className="font-medium">
                                                    City:
                                                </span>{" "}
                                                {selectedOrder.delivery_city_text ||
                                                    "-"}
                                            </div>
                                            <div className="text-sm">
                                                <span className="font-medium">
                                                    When:
                                                </span>{" "}
                                                {selectedOrder.delivery_day}{" "}
                                                {selectedOrder.delivery_time ||
                                                    ""}
                                            </div>
                                        </>
                                    ) : (
                                        <div className="text-sm">
                                            <span className="font-medium">
                                                Pickup:
                                            </span>{" "}
                                            {selectedOrder.pickup_day}{" "}
                                            {selectedOrder.pickup_time || ""}
                                        </div>
                                    )}
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Payment:
                                        </span>{" "}
                                        {selectedOrder.payment_method}
                                    </div>
                                </div>

                                <div>
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Subtotal:
                                        </span>{" "}
                                        {formatMoney(selectedOrder.subtotal)}
                                    </div>
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Add-ons:
                                        </span>{" "}
                                        {formatMoney(
                                            selectedOrder.addons_total
                                        )}
                                    </div>
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Delivery:
                                        </span>{" "}
                                        {formatMoney(
                                            selectedOrder.delivery_total
                                        )}
                                    </div>
                                    <div className="text-sm">
                                        <span className="font-medium">
                                            Total:
                                        </span>{" "}
                                        {formatMoney(selectedOrder.total)}
                                    </div>
                                    <div className="mt-1">
                                        <StatusPill
                                            status={selectedOrder.status}
                                        />
                                    </div>
                                </div>
                            </div>

                            {(selectedOrder.customer_observation ||
                                selectedOrder.addon_observation) && (
                                <div className="bg-neutral-50 border rounded p-3 text-sm">
                                    {selectedOrder.customer_observation && (
                                        <div>
                                            <span className="font-medium">
                                                Obs. customer:
                                            </span>{" "}
                                            {selectedOrder.customer_observation}
                                        </div>
                                    )}
                                    {selectedOrder.addon_observation && (
                                        <div>
                                            <span className="font-medium">
                                                Obs. add-ons:
                                            </span>{" "}
                                            {selectedOrder.addon_observation}
                                        </div>
                                    )}
                                </div>
                            )}

                            <div className="border rounded">
                                <table className="w-full text-sm">
                                    <thead className="bg-neutral-50">
                                        <tr>
                                            <th className="text-left px-3 py-2">
                                                Item
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Qty
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Unit
                                            </th>
                                            <th className="text-left px-3 py-2">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {selectedOrder.items.map((i) => (
                                            <tr key={i.id} className="border-t">
                                                <td className="px-3 py-2">
                                                    {i.product_name}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {i.quantity}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {formatMoney(i.unit_price)}
                                                </td>
                                                <td className="px-3 py-2">
                                                    {formatMoney(i.line_total)}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>

                            {/* Próximas ações */}
                            <div className="flex flex-wrap gap-2">
                                {nextSteps(selectedOrder.status).map(
                                    (status) => (
                                        <Button
                                            key={status}
                                            onClick={() =>
                                                updateOrderStatus(
                                                    selectedOrder,
                                                    status
                                                )
                                            }
                                        >
                                            Mark as {status}
                                        </Button>
                                    )
                                )}
                            </div>
                        </div>
                    )}
                </DialogContent>
            </Dialog>
        </>
    );
}
