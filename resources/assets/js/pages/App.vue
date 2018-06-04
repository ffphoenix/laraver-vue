<template>
    <div>
        <div class="app" v-if="$auth.check()">
            <AppHeader></AppHeader>
            <div class="app-body">
                <Sidebar :navItems="nav"/>
                <main class="main">
                    <router-view></router-view>
                </main>
            </div>
            <AppFooter></AppFooter>
        </div>
        <div v-if="!$auth.check()" class="container-fluid">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>
    import nav from '../components/navigation';
    import {Header as AppHeader, Sidebar, Footer as AppFooter, Breadcrumb} from '../components/panels/index';

    export default {
        name: 'app',
        components: {
            AppHeader,
            Sidebar,
            AppFooter,
            Breadcrumb
        },
        data() {
            return {
                nav: nav.items
            }
        },
        computed: {
            name() {
                return this.$route.name
            },
            list() {
                return this.$route.matched
            }
        }
    }
</script>
