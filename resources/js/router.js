import { createWebHistory,createRouter } from "vue-router";
import firstPage from "./components/mainapp.vue";
import home from "./components/pages/home.vue";
import tags from "./components/pages/tags.vue";
import adminusers from "./admin/pages/adminusers.vue";
import rolePermissions from "./admin/pages/rolePermissions.vue";
import roles from "./admin/pages/roles.vue";
import assignRole from "./admin/pages/assignRole.vue";
import permissions from "./admin/pages/permissions.vue";
import partiesAccountTransaction from "./admin/pages/partiesAccountTransaction.vue";
import partiesTransaction from "./admin/pages/partiesTransaction.vue";
import trasnsactions from "./admin/pages/trasnsactions.vue";
import parties from "./admin/pages/parties.vue";
import accountSubAccounts from "./admin/pages/accountSubAccounts.vue";
import subAccounts from "./admin/pages/subAccounts.vue";
import accounts from "./admin/pages/accounts.vue";
import login from "./admin/pages/login.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: home,
    },
    {
        path: "/login",
        name: "login",
        component: login,
    },{
        path: "/tags",
        name: "tags",
        component: tags,
    },{
        path: "/firstPage",
        name: "firstPage",
        component: firstPage,
    },
    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers'

    },
    {
        path: '/accounts',
        component: accounts,
        name: 'accounts'

    },
    {
        path: '/subAccounts',
        component: subAccounts,
        name: 'subAccounts'

    },
    {
        path: '/accountSubAccounts',
        component: accountSubAccounts,
        name: 'accountSubAccounts'

    },
    {
        path: '/parties',
        component: parties,
        name: 'parties'

    },
    {
        path: '/trasnsactions',
        component: trasnsactions,
        name: 'trasnsactions'

    },{
        path: '/partiesTransaction',
        component: partiesTransaction,
        name: 'partiesTransaction'

    },{
        path: '/partiesAccountTransaction',
        component: partiesAccountTransaction,
        name: 'partiesAccountTransaction'

    },{
        path: '/roles',
        component: roles,
        name: 'roles'

    },{
        path: '/assignRole',
        component: assignRole,
        name: 'assignRole'

    },{
        path: '/permissions',
        component: permissions,
        name: 'permissions'

    },{
        path: '/rolePermissions',
        component: rolePermissions,
        name: 'rolePermissions'

    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
