<script setup>
import {onMounted, ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import {Category} from "@/category.ts";

const csrfToken = usePage().props.auth['csrf_token'];
const props = defineProps(['id', 'title', 'category']);
const authorName = ref('N/A');
const createdTime = ref('N/A');
const viewCount = ref('0 view');

onMounted(() => {
    fetchAuthorName();
    fetchCreatedTime();
    fetchViewCount();
});

watch(props,  () => {
    fetchAuthorName();
    fetchCreatedTime();
    fetchViewCount();
});

function getLink() {
    return route('forum.thread.show', { id: props.id });
}

function getCategory() {
    return Category.byId(props.category);
}

function fetchAuthorName() {
    fetchData(route('forum.thread.author-name'))
        .then(text => authorName.value = text);
}

function fetchCreatedTime() {
    fetchData(route('forum.thread.created-time'))
        .then(text => createdTime.value = text);
}

function fetchViewCount() {
    fetchData(route('forum.thread.view-count'))
        .then(text => parseInt(text ? text : '0'))
        .then(count => {
            // todo l18n
            if (count > 1) {
                viewCount.value = count + " views";
            } else {
                viewCount.value = count + " view";
            }
        });
}

function fetchData(url) {
    let locator = new URL(url);
    let params = locator.searchParams;
    params.append('id', props.id);

    return fetch(locator, {
        method: 'GET',
        headers: { 'X-CSRF-Token': csrfToken }
    }).then(r => r.text(), reason => console.error(`Failed to fetch data: ${reason}`));
}
</script>

<template>
    <tr class="flex flex-row items-center rounded-lg border-solid border-2 m-4">
        <td class="p-8 flex-shrink-0">
            <i class="fa-solid fa-circle-user fa-3x"></i>
        </td>
        <td class="flex-grow">
            <a :href="getLink()">
                <div>
                    <span class="text-black text-lg font-bold">{{ title }}</span>
                    <div class="mt-2">
                        <svg class="inline-block w-[8px] h-[16px]">
                            <g :fill="getCategory().getColor()">
                                <rect width="100%" height="100%"/>
                            </g>
                        </svg>
                        <span class="text-black text-sm ps-2 pe-8">{{ getCategory().getName() }}</span>
                        <i class="fa-solid fa-user align-text-bottom"></i>
                        <span class="text-black text-sm ps-2">{{ authorName }}</span>
                    </div>
                </div>
            </a>
        </td>
        <td class="flex flex-col flex-shrink-0 w-[170px]">
            <div>
                <i class="fa-solid fa-clock"></i>
                <span class="px-2">{{ createdTime }}</span>
            </div>
            <div>
                <i class="fa-solid fa-eye fa-sm"></i>
                <span class="px-2">{{ viewCount }}</span>
            </div>
        </td>
    </tr>
</template>
