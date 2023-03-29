import { createRouter, createWebHistory } from "vue-router";
const auth = window.authUser || null;
const routes = [

    {
        path: "/",
        name: "home",
        component: () => import("../views/Main/Home.vue"),
        meta: { 
            title: "Dashboard", 
            menuName: "Dashboard", 
            icon: 'homeIcon' 
        },
    },

    {
        path: "/register",
        name: "register",
        component: () => import("../views/Auth/SignUp.vue"),
        meta: { 
            title: "SignUp", 
            menuName: "SignUp", 
            icon: null, 
            status: 0,
            isAuthenticated: true,
        },
    },

    {
        path: "/referrals/create",
        name: "createReferrals",
        component: () => import("../views/Referral/Referral.vue"),
        meta: { 
            title: "Create referral", 
            menuName: "Create referral", 
            icon: 'homeIcon',
        },
    },

    {
        path: "/admin/referrals",
        name: "referralList",
        component: () => import("../views/Referral/ReferralList.vue"),
        meta: { 
            title: "Referral List", 
            menuName: "Referral List", 
            icon: 'homeIcon',
            status: (auth && auth.user_type === 'ADMIN')
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {

    document.title = to.meta.title;
    if (to.meta.isAuthenticated && to.name === 'register' && auth) next({ name: 'home' })
    else next()
    // next()
});

export default router;
