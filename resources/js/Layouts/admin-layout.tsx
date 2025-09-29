import { PropsWithChildren } from "react";
import { Link, router, usePage } from "@inertiajs/react";

type AdminUser = {
    id: number;
    name: string;
    email: string;
    photo?: string | null;
    role: "superadmin" | "admin" | "user";
};

type PageProps = {
    auth: {
        admin: AdminUser | null;
    };
};

function NavLink({
    href,
    label,
    active,
}: {
    href: string;
    label: string;
    active?: boolean;
}) {
    return (
        <Link
            href={href}
            className={`px-3 py-2 rounded-xl text-sm ${
                active
                    ? "bg-neutral-900 text-white"
                    : "text-neutral-600 hover:bg-neutral-100"
            }`}
        >
            {label}
        </Link>
    );
}

export default function AdminLayout({ children }: PropsWithChildren) {
    const { props } = usePage<PageProps>();
    const admin = props.auth?.admin;

    function logout() {
        router.post(route("admin.logout"));
    }

    return (
        <div className="min-h-screen bg-neutral-50">
            <header className="sticky top-0 z-40 border-b bg-white">
                <div className="mx-auto max-w-7xl px-4 py-3 flex items-center gap-3">
                    <button
                        className="md:hidden inline-flex items-center justify-center p-2 rounded-lg border"
                        onClick={() => {
                            const el = document.getElementById("admin-drawer");
                            if (el) el.classList.toggle("-translate-x-full");
                        }}
                    >
                        <span className="i-lucide-menu w-5 h-5" />
                    </button>

                    <Link
                        href={route("admin.dashboard")}
                        className="font-semibold"
                    >
                        Cookieland • Admin
                    </Link>

                    <nav className="ml-4 hidden md:flex items-center gap-2">
                        <NavLink
                            href={route("admin.dashboard")}
                            label="Dashboard"
                            active={route().current("admin.dashboard")}
                        />
                        <NavLink
                            href={route("admin.products")}
                            label="Products"
                            active={route().current("admin.products")}
                        />
                        <NavLink
                            href={route("admin.orders")}
                            label="Orders"
                            active={route().current("admin.orders")}
                        />
                        <NavLink
                            href={route("admin.addons")}
                            label="Add-ons"
                            active={route().current("admin.addons")}
                        />
                    </nav>

                    <div className="ml-auto flex items-center gap-3">
                        {admin && (
                            <div className="flex items-center gap-3">
                                <img
                                    src={
                                        admin.photo ||
                                        "https://www.gravatar.com/avatar/?d=mp&s=80"
                                    }
                                    alt={admin.name}
                                    className="w-9 h-9 rounded-full border object-cover"
                                />
                                <div className="hidden sm:flex flex-col leading-tight">
                                    <span className="text-sm font-medium">
                                        {admin.name}
                                    </span>
                                    <span className="text-xs text-neutral-500">
                                        {admin.role}
                                    </span>
                                </div>
                                <button
                                    onClick={logout}
                                    className="ml-2 px-3 py-2 text-sm rounded-xl border hover:bg-neutral-50"
                                >
                                    Logout
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            </header>

            {/* Drawer mobile */}
            <div
                id="admin-drawer"
                className="fixed inset-y-0 left-0 w-64 bg-white border-r p-4 transform -translate-x-full transition md:hidden"
            >
                <div className="mb-4 flex items-center justify-between">
                    <span className="font-semibold">Menu</span>
                    <button
                        className="p-2 rounded-lg border"
                        onClick={() => {
                            const el = document.getElementById("admin-drawer");
                            if (el) el.classList.add("-translate-x-full");
                        }}
                    >
                        <span className="i-lucide-x w-5 h-5" />
                    </button>
                </div>

                <nav className="flex flex-col gap-2">
                    <NavLink
                        href={route("admin.dashboard")}
                        label="Dashboard"
                        active={route().current("admin.dashboard")}
                    />
                    <NavLink
                        href={route("admin.products")}
                        label="Products"
                        active={route().current("admin.products")}
                    />
                    <NavLink
                        href={route("admin.orders")}
                        label="Orders"
                        active={route().current("admin.orders")}
                    />
                    <NavLink
                        href={route("admin.addons")}
                        label="Add-ons"
                        active={route().current("admin.addons")}
                    />
                    <button
                        onClick={logout}
                        className="mt-2 px-3 py-2 text-left text-sm rounded-xl border hover:bg-neutral-50"
                    >
                        Logout
                    </button>
                </nav>
            </div>

            <main className="mx-auto max-w-7xl px-4 py-6">{children}</main>
        </div>
    );
}
