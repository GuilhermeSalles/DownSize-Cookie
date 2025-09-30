<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\Product;

class ProductPolicy
{
    // AdminUser vem do guard 'admin'
    public function create(?AdminUser $user): bool
    {
        // só superadmin cria
        return $user && strcasecmp($user->role, 'superadmin') === 0;
    }

    public function update(?AdminUser $user, Product $product): bool
    {
        // qualquer admin pode editar nome/preço/descrição;
        // trocar imagem/categoria só superadmin (já está validado no controller com Gate)
        return $user && in_array($user->role, ['admin', 'superadmin'], true);
    }
}
