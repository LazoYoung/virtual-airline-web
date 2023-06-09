<script setup>
import {Head} from '@inertiajs/vue3';
import {reactive} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MainLayout from '@/Layouts/MainLayout.vue';
import AirportModal from "@/Components/AirportModal.vue";
import DestinationMap from "@/Components/DestinationMap.vue";

const props = defineProps({
    isAdmin: {
        type: Boolean,
        default: false
    },
    mapApiKey: {
        type: String,
    },
    canLogin: {
        type: Boolean
    },
    canRegister: {
        type: Boolean
    },
    laravelVersion: {
        type: String,
        required: true
    },
    phpVersion: {
        type: String,
        required: true
    },
});
const modal = reactive({
    airport: false,
});

function openAirportModal() {
    modal.airport = true;
}
</script>

<style scoped>
/* Hides ugly scrollbars */
div {
    scrollbar-width: none;
}
div::-webkit-scrollbar {
    display: none;
}

/* Viewport - navbar height */
.h-content {
    height: calc(100vh - 4rem);
}
</style>

<template>
    <Head title="Home" />

    <MainLayout :inner-body="true">
        <div class="fixed w-full h-full">
            <video class="object-cover w-full h-full" autoplay loop muted disablePictureInPicture>
                <source src="/promo.mp4">
            </video>
        </div>

        <div class="z-10 w-full h-content p-0 overflow-y-scroll">
            <article class="relative h-full flex flex-col text-center">
                <div class="flex-grow invisible"></div>
                <div>
                    <h1 class="text-5xl text-white font-bold">We are virtual aviators.</h1>
                    <div class="h-10 invisible"></div>
                    <a :href="route('register')">
                        <button class="inline-block text-white bg-cyan-600 px-4 py-2">Join us</button>
                    </a>
                </div>
                <div class="flex-grow flex flex-col">
                    <div class="flex-grow invisible"></div>
                    <div class="h-16">
                        <i class="fa-solid fa-angles-down fa-fade fa-2xl" style="color: #ffffff;"></i>
                    </div>
                </div>
            </article>

            <article class="relative h-content bg-black sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="pt-16">
                        <h1 class="text-4xl text-white text-center font-bold">Destinations</h1>
                        <p class="text-gray-200 text-center py-4">
                            These cities are served by the airline's scheduled flights.
                            <br>
                            We will continue to expand our flight network.
                        </p>
                        <div class="flex flex-row justify-end mb-6">
                            <PrimaryButton v-if="isAdmin" @click="openAirportModal">
                                Add airport
                            </PrimaryButton>
                        </div>
                        <DestinationMap class="h-96" :api-key="mapApiKey"></DestinationMap>
                    </div>

                    <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                        <div class="text-center text-sm text-white dark:text-gray-400 sm:text-left">
                            <div class="flex items-center gap-4">
                                <a
                                    href="https://github.com/LazoYoung/naru-aviation-web"
                                    target="_blank"
                                    class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                >
                                    <i class="fa-brands fa-github"></i>
                                    <p class="ms-2">Crafted by Chanyoung Park</p>
                                </a>
                            </div>
                        </div>

                        <div class="ml-4 text-center text-sm text-white dark:text-gray-400 sm:text-right sm:ml-0">
                            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <AirportModal :show="modal.airport" @close="modal.airport = false"></AirportModal>
    </MainLayout>
</template>
