<template>
    <PageComponent title="Post">
        <div
            v-if="posts.loading"
            class="flex items-center justify-center space-x-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="{2.5}"
                stroke="currentColor"
                class="animate-spin w-20 h-20"
            >
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                />
            </svg>
        </div>
        <div v-if="!posts.loading" class="flex flex-col">
            <VueTailwindPagination
                :current="posts.data.current_page"
                :total="posts.data.total"
                :per-page="posts.data.per_page"
                @page-changed="paginateAction($event)"
                text-before-input="Go to Page"
                text-after-input=""
            />
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-100 sm:px-6 lg:px-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed">
                            <thead class="border-b">
                                <tr>
                                    <th
                                        scope="col"
                                        class="text-sm font-medium text-gray-900 px-6 py-4 text-center bg-gray-200"
                                    >
                                        Publish Date
                                    </th>
                                    <th
                                        scope="col"
                                        class="text-sm font-medium text-gray-900 px-6 py-4 text-center bg-gray-200"
                                    >
                                        Title
                                    </th>
                                    <th
                                        scope="col"
                                        class="text-sm font-medium text-gray-900 px-6 py-4 text-center bg-gray-200"
                                    >
                                        Author
                                    </th>
                                    <th
                                        scope="col"
                                        class="text-sm font-medium text-gray-900 px-6 py-4 text-center bg-gray-200"
                                    >
                                        Category
                                    </th>
                                    <th
                                        scope="col"
                                        class="text-sm font-medium text-gray-900 px-6 py-4 text-center bg-gray-200"
                                    >
                                        Tags
                                    </th>
                                    <th
                                        scope="col"
                                        class="text-sm font-medium text-gray-900 px-6 py-4 text-center bg-gray-200"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="post in posts.data.items"
                                    :key="post.slug"
                                    class="border-b"
                                >
                                    <td
                                        class="text-sm text-gray-900 font-light px-6 py-4"
                                    >
                                        <button
                                            type="button"
                                            v-on:click="
                                                publishPost(
                                                    post.id,
                                                    post.published_at
                                                )
                                            "
                                            :class="
                                                post.published_at !== null
                                                    ? 'border-red-600 text-red-600 hover:bg-red-600'
                                                    : 'border-blue-600 text-blue-600 hover:bg-blue-600'
                                            "
                                            class="w-full inline-block px-6 py-2 border-2 font-medium text-xs leading-normal uppercase rounded hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                                        >
                                            {{ post.published_at ?? "Publish" }}
                                        </button>
                                    </td>
                                    <td
                                        class="text-sm text-gray-900 font-light px-6 py-4"
                                    >
                                        {{ post.title }}
                                    </td>
                                    <td
                                        class="text-sm text-gray-900 font-light px-6 py-4"
                                    >
                                        {{ post.author.name }}
                                    </td>
                                    <td
                                        class="text-sm text-gray-900 font-light px-6 py-4"
                                    >
                                        {{ post.category.title }}
                                    </td>
                                    <td
                                        class="text-sm text-gray-900 font-light px-6 py-4"
                                    >
                                        {{
                                            post.tags
                                                .map((entry) => entry.title)
                                                .join(", ")
                                        }}
                                    </td>
                                    <td
                                        class="text-sm text-gray-900 font-light px-6 py-4"
                                    >
                                        <div
                                            class="grid grid-cols-2 gap-2 place-content-around"
                                        >
                                            <button
                                                type="button"
                                                class="inline-block justify-items-center px-1 py-1.5 bg-red-600 text-white text-center font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                @click="openModal"
                                                class="inline-block justify-items-center px-1 py-1.5 bg-blue-600 text-white text-center font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    className="w-5 h-5"
                                                >
                                                    <path
                                                        d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z"
                                                    />
                                                    <path
                                                        d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="flex justify-start my-3">
                <div class="w-1/16 mx-1 px-2 py-0.5 rounded bg-slate-200">
                    from: {{ posts.data.from }}
                </div>
                <div class="w-1/16 mx-1 px-2 py-0.5 rounded bg-slate-200">
                    to: {{ posts.data.to }}
                </div>
            </div>
        </div>
        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>
                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-screen max-h-screen transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900"
                                >
                                    Edit Post
                                </DialogTitle>
                                <div class="mt-2">
                                    <form action="#" method="POST">
                                        <div
                                            class="overflow-hidden shadow sm:rounded-md"
                                        >
                                            <div
                                                class="bg-white px-4 py-5 sm:p-6"
                                            >
                                                <div
                                                    class="grid grid-cols-12 gap-6"
                                                >
                                                    <div class="col-span-10">
                                                        <label
                                                            for="Post Title"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Post Title</label
                                                        >
                                                        <input
                                                            type="text"
                                                            name="post-title"
                                                            id="post-title"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col justify-between col-span-2"
                                                    >
                                                        <div class="">
                                                            <label
                                                                for="toggle-publish"
                                                                >Publish After
                                                                Create?</label
                                                            >
                                                        </div>
                                                        <div class="">
                                                            <label
                                                                class="relative inline-block w-16 h-5 rounded-full"
                                                            >
                                                                <input
                                                                    type="checkbox"
                                                                    id="toggle-publish"
                                                                    class="peer opacity-0 w-0 h-0"
                                                                />
                                                                <span
                                                                    class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 rounded-full duration-300 before:content-[''] before:absolute before:w-7 before:h-3 before:bottom-1 before:left-1 before:rounded-full before:bg-white before:duration-300 peer-checked:before:translate-x-7 peer-checked:bg-blue-500"
                                                                ></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-span-12 sm:col-span-12"
                                                    >
                                                        <label
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Thumbnail
                                                            Image</label
                                                        >
                                                        <div
                                                            class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
                                                        >
                                                            <div
                                                                class="space-y-1 text-center"
                                                            >
                                                                <svg
                                                                    class="mx-auto h-12 w-12 text-gray-400"
                                                                    stroke="currentColor"
                                                                    fill="none"
                                                                    viewBox="0 0 48 48"
                                                                    aria-hidden="true"
                                                                >
                                                                    <path
                                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                        stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                    />
                                                                </svg>
                                                                <div
                                                                    class="flex text-sm text-gray-600"
                                                                >
                                                                    <label
                                                                        for="file-upload"
                                                                        class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
                                                                    >
                                                                        <span
                                                                            >Upload
                                                                            a
                                                                            file</span
                                                                        >
                                                                        <input
                                                                            id="file-upload"
                                                                            name="file-upload"
                                                                            type="file"
                                                                            class="sr-only"
                                                                        />
                                                                    </label>
                                                                    <p
                                                                        class="pl-1"
                                                                    >
                                                                        or drag
                                                                        and drop
                                                                    </p>
                                                                </div>
                                                                <p
                                                                    class="text-xs text-gray-500"
                                                                >
                                                                    PNG, JPG,
                                                                    GIF up to
                                                                    10MB
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-span-4"
                                                    ></div>
                                                    <div class="col-span-8">
                                                        <label for="tags"
                                                            >Tags</label
                                                        >
                                                        <Multiselect
                                                            id="tags"
                                                            v-model="value"
                                                            :options="options"
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-start-1 col-end-13"
                                                    >
                                                        <label for="message"
                                                            >Body</label
                                                        >
                                                        <textarea
                                                            id="message"
                                                            rows="4"
                                                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                            placeholder="Your message..."
                                                        ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="mt-4 flex justify-between">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-red-900 hover:bg-red-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    >
                                        Save
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
// import { trash } from "@heroicons/vue";
import { ref } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { computed } from "vue";
import store from "../store";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";
import "@ocrv/vue-tailwind-pagination/styles";
import service from "../services/_baseService";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

const posts = computed(() => store.state.posts);
const perPageArray = [5, 10, 15, 20, 25, 30];
const isOpen = ref(false);
let value = {
    mode: "tags",
    closeOnSelect: false,
    value: [],
    placeholder: "Choose your stack",
    filterResults: false,
    minChars: 1,
    resolveOnLoad: false,
    delay: 0,
    searchable: true,
    options: async (query) => {
        return await fetchLanguages(query);
    },
};
const options = ["Batman", "Robin", "Joker"];

store.dispatch("getPosts");

function closeModal() {
    isOpen.value = false;
}
function openModal() {
    isOpen.value = true;
}
async function paginateAction(ev) {
    store.state.posts.page = ev;
    let res = await store.dispatch("getPosts");
}
function publishPost(ev, published) {
    console.log(ev, published);
    service
        .post("admin/form/publish", {
            postId: ev,
            unPublished: published === null ? false : true,
        })
        .then((res) => {
            // console.log(res);
            store.dispatch("getPosts");
        });
}
</script>

<style></style>
