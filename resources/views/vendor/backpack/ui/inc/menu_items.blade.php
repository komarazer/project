{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="User Data" icon="la la-users">
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Employees" icon="la la-briefcase" :link="backpack_url('employee')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Permission Config" icon="la la-users">
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-question" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Departments" icon="la la-question" :link="backpack_url('department')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Product" icon="la la-users">
    <x-backpack::menu-dropdown-item title="Products" icon="la la-question" :link="backpack_url('product')" />
    <x-backpack::menu-dropdown-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
</x-backpack::menu-dropdown>
