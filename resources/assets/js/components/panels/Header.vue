<template>
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button" @click="mobileSidebarToggle">
            &#9776;
        </button>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" @click="sidebarMinimize">&#9776;
        </button>
        <b-nav is-nav-bar class="ml-auto">
            <b-nav-item-dropdown right>
                <template slot="button-content">
                    <span class="d-md-down-none">{{ $auth.user().name }} ({{ $auth.user().email }})</span>
                </template>
                <b-dropdown-item @click.prevent="$auth.logout({redirect: '/login'})"><i class="fa fa-lock"></i> Logout
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-nav>
        <div class="navbar-toggler d-md-down-none"></div>
    </header>
</template>
<script>
    export default {
        name: 'iheader',
        methods: {
            sidebarToggle(e) {
                e.preventDefault()
                document.body.classList.toggle('sidebar-hidden')
            },
            sidebarMinimize(e) {
                e.preventDefault()
                document.body.classList.toggle('sidebar-minimized')
            },
            mobileSidebarToggle(e) {
                e.preventDefault()
                document.body.classList.toggle('sidebar-mobile-show')
            }
        }
    }
</script>
