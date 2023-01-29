import { createStore } from "vuex";
import service from "../services/_baseService";

const tmpEvent = [
    {
        id: "984c24f0-abfe-4e53-88be-1e24d0a4d303",
        title: "dolores inventore et",
        slug: "dolores-inventore-et",
        user_id: "984c24e7-faf8-4335-af78-e9ff39993cd2",
        description:
            "Facere sit veritatis amet et ut libero. Aut harum reiciendis quibusdam veniam aut excepturi quo. At omnis necessitatibus et sit est sapiente. Illo qui odio autem ipsam autem adipisci.",
        excerpt:
            "Facere sit veritatis amet et ut libero. Aut harum reiciendis quibusdam veniam aut excepturi quo. At...",
        publish_date: "1993-10-24 04:50:41",
        expire: "1993-10-26 16:20:39",
        deleted_at: null,
        created_at: "2023-01-24T02:40:46.000000Z",
        updated_at: "2023-01-24T02:40:46.000000Z",
        author: {
            id: "984c24e7-faf8-4335-af78-e9ff39993cd2",
            name: "Giovanni Howell MD",
            username: "giovannihowellmd",
            email: "alvah.torphy@example.com",
            email_verified_at: "2023-01-24T02:40:40.000000Z",
            created_at: "2023-01-24T02:40:41.000000Z",
            updated_at: "2023-01-24T02:40:41.000000Z",
        },
        media: [
            {
                id: "984c24fc-4c1e-481f-9225-c789c6236b9d",
                path: "https://source.unsplash.com/random?technologies",
                mediable_type: "App\\Models\\Form",
                mediable_id: "984c24f0-abfe-4e53-88be-1e24d0a4d303",
                deleted_at: null,
                created_at: "2023-01-24T02:40:54.000000Z",
                updated_at: "2023-01-24T02:40:54.000000Z",
            },
        ],
    },
];

const store = createStore({
    state: {
        user: {
            data: {
                name: "koetjeeng",
                email: "tom@example.com",
                imageUrl: "https://source.unsplash.com/random/?user",
            },
            token: sessionStorage.getItem("TOKEN"),
        },
        posts: {
            loading: false,
            perPage: 15,
            page: 1,
            published_only: false,
            data: [],
        },
        forms: {
            loading: false,
            perPage: 15,
            page: 1,
            published_only: false,
            data: [],
        },
    },
    getters: {},
    actions: {
        login({ commit }, user) {
            return service
                .post("/auth/login", JSON.stringify(user))
                .then((res) => {
                    commit("setUser", res.data);
                    return res;
                });
        },
        logout({ commit }) {
            return service.get("/auth/logout").then((res) => {
                commit("logout");
                return res;
            });
        },
        getProfile({ commit }) {
            return service.get("/auth/profile").then((res) => {
                commit("setProfile", res.data);
                return res;
            });
        },
        getPosts({ commit }) {
            commit("setPostsLoading", true);
            return service
                .get("/admin/postList", {
                    params: {
                        perPage: this.state.posts.perPage,
                        page: this.state.posts.page,
                        published_only: this.state.posts.published_only,
                    },
                })
                .then((res) => {
                    commit("setPostsLoading", false);
                    commit("setPosts", res.data);
                    return res;
                });
        },
        getForms({ commit }) {
            commit("setFormsLoading", true);
            return service
                .get("/admin/formList", {
                    perPage: this.state.forms.perPage,
                    page: this.state.forms.page,
                    published_only: this.state.forms.published_only,
                })
                .then((res) => {
                    commit("setFormsLoading", false);
                    commit("setForms", res.data);
                    return res;
                });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem("TOKEN");
        },
        setUser: (state, userData) => {
            state.user.token = userData.access_token;
            state.user.data = userData.user;
            sessionStorage.setItem("TOKEN", userData.access_token);
        },
        setProfile: (state, userProfile) => {
            state.user.data = userProfile;
        },
        setPostsLoading: (state, loading) => {
            state.posts.loading = loading;
        },
        setPosts: (state, posts) => {
            state.posts.data = posts;
        },
        setFormsLoading: (state, loading) => {
            state.forms.loading = loading;
        },
        setForms: (state, forms) => {
            state.forms.data = forms;
        },
    },
    modules: {},
});

export default store;
