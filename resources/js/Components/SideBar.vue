<template>
    <aside id="sidebar" :class="{ active: sideBarActive }" class="w-full p-1  dark:bg-gray-900 dark:text-gray-100 h-auto">
        <div class="sidebar-header">

            <div class="logo">
                <img src="/images/vnwaLogoFull.png" class="show" alt="Vinawebapp Logo">
                <img src="/images/vnwaLogoIcon.png" class="hide" alt="Vinawebapp Logo">
            </div>
            <!-- <div class="btn" @click="toggleSidebar">
                <span className='relative inline-block overflow-hidden rounded-full p-[1px]'>
                    <span className='absolute inset-[-1000%] animate-[spin_2s_linear_infinite] bg-[conic-gradient(from_90deg_at_50%_50%,#E2CBFF_0%,#393BB2_50%,#E2CBFF_100%)]' />
                    <div className='inline-flex h-full w-full cursor-pointer items-center justify-center rounded-full bg-slate-950/90 px-3 py-1 text-sm font-medium text-white backdrop-blur-3xl'>
                        <icon icon="fa-xmark" class="show" />
                        <icon icon="fa-bars" class="hide" />
                    </div>
                </span>
            </div> -->
        </div>
        <div class="sidebar-content">
            <ul id="sidebar-content-list">
                <li class="mb-3">
                    <SideBarLink :href="route('dashboard')" :active="check('/dashboard')">
                        <icon icon="fa-home" class="mr-2" />
                        <span class="show  font-semibold text-slate-900 dark:text-slate-200">Trang chủ</span>
                    </SideBarLink>
                </li>
                <li class="mb-3">
                    <SideBarLink :href="route('ProductBanner')" :active="check('/product-banner')">
                        <icon icon="fa-image" class="mr-2" />
                        <span class="show  font-semibold text-slate-900 dark:text-slate-200">Banner</span>
                    </SideBarLink>
                </li>
                <li class="mb-3">
                    <SideBarLink :href="route('Category')" :active="check('/category')">
                        <icon icon="fa-list" class="mr-2" />
                        <span class="show  font-semibold text-slate-900 dark:text-slate-200">Danh mục</span>
                    </SideBarLink>
                </li>
                <li class="mb-3">
                    <SideBarLink :href="route('Year')" :active="check('/year')">
                        <icon icon="fa-calendar-days" class="mr-2" />

                        <span class="show  font-semibold text-slate-900 dark:text-slate-200">Năm</span>
                    </SideBarLink>
                </li>

                <li class="mb-3">
                    <SideBarLink :href="route('Nation')" :active="check('/nation')">
                        <icon icon="fa-location-dot" class="mr-2" />

                        <span class="show  font-semibold text-slate-900 dark:text-slate-200">Quốc gia</span>
                    </SideBarLink>
                </li>
                <li class="mb-3">
                    <SideBarLink :href="route('Type')" :active="check('/type')">
                        <icon icon="fa-table-list" class="mr-2" />
                        <span class="show  font-semibold text-slate-900 dark:text-slate-200">Thể loại</span>
                    </SideBarLink>
                </li>

                <li class="mb-3">
                    <div class=" cursor-pointer relative w-100 py-2 px-4 rounded sidebar-item-list " :class="{ active: isProjects || check('/product-series') || check('/product-feature') || check('/product-cinema') }">
                        <div class="flex items-center justify-start sidebar-item-list-title" @click=" this.isProjects = !this.isProjects;">
                            <icon icon="fa-film" class="mr-2" />
                            <span class="show  font-semibold text-slate-900 dark:text-slate-200">Phim </span>
                            <icon :icon="['fas', 'chevron-down']" class="ml-2 show" />
                        </div>

                        <div class="sidebar-item-list-content  mt-3">
                            <ul class=" border-l border-purple-100">
                                <li class="mb-1">
                                    <SideBarMenuItemLink :href="route('ProductSeries')" :active="check('/product-series')">
                                        Phim Bộ
                                    </SideBarMenuItemLink>
                                </li>
                                <li class="mb-1">
                                    <SideBarMenuItemLink :href="route('ProductFeature')" :active="check('/product-feature')">
                                        Phim Lẻ
                                    </SideBarMenuItemLink>
                                </li>
                                <li class="mb-1">
                                    <SideBarMenuItemLink :href="route('ProductCinema')" :active="check('/product-cinema')">
                                        Phim Chiếu Rạp
                                    </SideBarMenuItemLink>
                                </li>
                            </ul>
                        </div>
                    </div>

                </li>


            </ul>
        </div>
    </aside>
</template>
<script>
import SideBarLink from '@/Components/SideBarLink.vue';
import SideBarMenuItemLink from '@/Components/SideBarMenuItemLink.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

export default {
    created() {

    },
    data() {
        return {
            isProjects: false,
            isBlogs: false,
        }
    },

    name: 'SideBar',
    components: {
        SideBarLink, SideBarMenuItemLink, Link
    },

    computed: {

        sideBarActive() {
            // return this.$store.state.sideBarActive;
            return false
        },
    },
    methods: {
        check(path) {
            const { url } = usePage();

            if (url.includes(path)) {
                return true;
            } else {
                return false;

            }
            // return isActive;
        },
        toggleSidebar() {
            this.$store.commit('toggleSidebar');
        },

    },
    setup() {

    },

};
</script>
