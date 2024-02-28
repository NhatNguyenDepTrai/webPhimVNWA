<template>
    <AppLayout title="Thông tin website">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Thông tin website
            </h2>
        </template>
        <div class="overflow-hidden  px-5 mb-3 bg-black">
            <div class="w-100  p-1 flex justify-between items-center">
                <div class="  ">

                </div>
                <div class="">
                    <button type="button" @click="submitForm" class="text-gray-900 bg-gradient-to-r from-purple-200 via-purple-400 to-purple-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <icon :icon="['fas', 'save']" class="mr-2" /> Lưu Dữ Liệu
                    </button>
                </div>
            </div>
        </div>
        <div class="pb-12 pt-4">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-12 relative">

                    <div class="xl:col-span-9 col-span-12 p-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">

                            <div class="mb-3">
                                <label for="name" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Tên Đầy Đủ Công Ty</label>
                                <input type="text" v-model="name" placeholder="VD: Công ty TNHH Công Nghệ Vinawebapp.com" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_name">{{ error.name }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="short_name" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Tên Viết Tắt</label>
                                <input type="text" v-model="short_name" placeholder="VD: Vinawebapp.com" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_short_name">{{ error.short_name }}</span>
                            </div>


                            <div class="mb-3">
                                <label for="slogan" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Slogan</label>
                                <input type="text" v-model="slogan" placeholder="VD: Sản Phẩm Của Bạn Chất Lượng.Chúng Tôi Biết.Nhưng Khách Hàng Vẫn Chưa Biết Đến Bạn." class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_slogan">{{ error.slogan }}</span>
                            </div>






                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">
                            <div class="mb-3">
                                <label for="website" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Website</label>
                                <input type="text" v-model="website" placeholder="VD: https://vinawebapp.com/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_website">{{ error.website }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize ">Số điện thoại</label>
                                <input type="text" v-model="phone" placeholder="VD: 0787679729" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_phone">{{ error.phone }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="hotline" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Hotline</label>
                                <input type="text" v-model="hotline" placeholder="VD: 0787679729" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_hotline">{{ error.hotline }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="mail" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Mail Công Ty</label>
                                <input type="text" v-model="mail" placeholder="VD: vinawebapp.com@gmail.com" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_mail">{{ error.mail }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="mail" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Mail Hỗ Trợ</label>
                                <input type="text" v-model="support_mail" placeholder="VD: vinawebapp.com@gmail.com" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_support_mail">{{ error.support_mail }}</span>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg  mb-3 d-block">
                            <div class="grid grid-cols-12 relative">
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="zalo" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Zalo</label>
                                        <input type="text" v-model="zalo" placeholder="VD: 0787679729" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_zalo">{{ error.zalo }}</span>
                                    </div>
                                </div>
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="facebook" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Facebook</label>
                                        <input type="text" v-model="facebook" placeholder="VD: https://www.facebook.com/vinawebapp/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_zalo">{{ error.facebook }}</span>
                                    </div>
                                </div>
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="instagram" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">instagram</label>
                                        <input type="text" v-model="instagram" placeholder="VD: https://www.facebook.com/vinawebapp/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_instagram">{{ error.instagram }}</span>
                                    </div>
                                </div>
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="youtube" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Youtube</label>
                                        <input type="text" v-model="youtube" placeholder="VD: https://www.facebook.com/vinawebapp/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_youtube">{{ error.youtube }}</span>
                                    </div>
                                </div>
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="tiktok" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Tiktok</label>
                                        <input type="text" v-model="tiktok" placeholder="VD: https://www.tiktok.com/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_tiktok">{{ error.tiktok }}</span>
                                    </div>
                                </div>
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="linkedin" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Linkedin</label>
                                        <input type="text" v-model="linkedin" placeholder="VD: https://www.linkedin.com/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_linkedin">{{ error.linkedin }}</span>
                                    </div>
                                </div>
                                <div class="col-span-6 p-3">
                                    <div class="mb-3">
                                        <label for="telegram" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Telegram</label>
                                        <input type="text" v-model="telegram" placeholder="VD: https://web.telegram.org/" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_telegram">{{ error.telegram }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 relative">
                            <div class="xl:col-span-3 col-span-12 p-1">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">
                                    <div class="mb-3 ">
                                        <label for="meta_image" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Meta Image</label>
                                        <InputUrlImage ref="get_meta_image" :data="meta_image" />
                                        <span class="text-red-600 text-xs" ref="scroll_meta_image">{{ error.meta_image }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="xl:col-span-9 col-span-12 p-1">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">
                                    <div class="mb-3">
                                        <label for="meta_title" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Meta Title</label>
                                        <input type="text" v-model="meta_title" placeholder="VD: Công ty TNHH Công Nghệ Vinawebapp.com" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_meta_title">{{ error.meta_title }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="meta_desc" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Meta Desc</label>
                                        <input type="text" v-model="meta_desc" placeholder="VD: Công ty TNHH Công Nghệ Vinawebapp.com" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                        <span class="text-red-600 text-xs" ref="scroll_meta_desc">{{ error.meta_desc }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="xl:col-span-3 col-span-12 p-1">

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">
                            <div class="mb-3 ">
                                <label for="url_avatar_full" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Logo Full</label>

                                <InputUrlImage ref="get_url_avatar_full" :data="url_avatar_full" />
                                <span class="text-red-600 text-xs" ref="scroll_url_avatar_full">{{ error.url_avatar_full }}</span>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">
                            <div class="mb-3">
                                <label for="url_avatar_icon" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Logo Icon</label>

                                <InputUrlImage ref="get_url_avatar_icon" :data="url_avatar_icon" />
                                <span class="text-red-600 text-xs" ref="scroll_url_avatar_icon">{{ error.url_avatar_icon }}</span>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">
                            <div class="mb-3">
                                <label for="url_favicon" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Favicon</label>

                                <InputUrlImage ref="get_url_favicon" :data="url_favicon" />
                                <span class="text-red-600 text-xs" ref="scroll_url_favicon">{{ error.url_favicon }}</span>
                            </div>
                        </div>


                    </div>
                    <input type="text" v-model="province" hidden>
                    <input type="text" v-model="district" hidden>
                    <input type="text" v-model="ward" hidden>
                    <div class="col-span-12 p-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">

                            <div class="mb-3">
                                <label for="sub_slogan" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Nhúng google map</label>
                                <textarea v-model="sub_slogan" cols="30" rows="5" placeholder="Nhúng google map" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            </textarea>
                                <span class="text-red-600 text-xs" ref="scroll_slogan">{{ error.sub_slogan }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 p-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 mb-3">

                            <label for="name" class="block mb-2 font-bold text-base text-gray-900 dark:text-dark">Nhập Mã Video Youtube </label>
                            <div class="text-base text-black/80">Vd: https://www.youtube.com/watch?v=mv-V2lKEi3E</div>
                            <div class="text-base text-black/80 mb-2">Mã sẽ là <span class="bg-black text-white px-5 ">mv-V2lKEi3E</span></div>
                            <input type="text" v-model="url_video" placeholder="Nhập Mã Video Youtube" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                            <span class="text-red-600 text-xs" ref="scroll_url_video">{{ error.url_video }}</span>

                        </div>
                    </div>

                    <div class="col-span-12 p-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 d-block">

                            <div class="mb-3">
                                <label for="address" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Địa chỉ</label>
                                <textarea v-model="address" cols="30" rows="10" placeholder="Nhập địa chỉ" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500">

</textarea>
                                <span class="text-red-600 text-xs" ref="scroll_address">{{ error.address }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 p-1">


                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 mb-3">

                            <div class="grid grid-cols-12 ">
                                <div class="xl:col-span-4 col-span-12 border border-sky-500 p-5">
                                    <div class="mb-3 ">
                                        <label for="url_avatar_about" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">About Image</label>
                                        <InputUrlImage ref="get_url_avatar_about" :data="url_avatar_about" />
                                        <span class="text-red-600 text-xs" ref="scroll_url_avatar_about">{{ error.url_avatar_about }}</span>
                                    </div>
                                </div>
                                <div class="xl:col-span-8 col-span-12 border border-sky-500 p-5">
                                    <div class="mb-3 ">
                                        <label for="url_avatar_about" class="block mb-2 font-bold text-base  text-gray-900 dark:text-dark capitalize">Short About</label>
                                        <textarea v-model="shortAbout" cols="30" rows="10" placeholder="Nhập shortAbout" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                        </textarea>

                                        <span class="text-red-600 text-xs" ref="scroll_shortAbout">{{ error.shortAbout }}</span>
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <hr>
                                    <label for="editer" class="block mb-2 text-base text-center mt-10 uppercase font-extrabold text-gray-900 dark:text-dark">About Content</label>
                                    <Editer ref="getAbout" :data="about" />
                                    <div class="w-full text-red-600 text-xs bg-black my-1 text-center " ref="scroll_about">

                                        {{ error.about }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>

        <div class="overflow-hidden  px-5 mb-3 bg-black">
            <div class="w-100  p-1 flex justify-between items-center">
                <div class="  ">

                </div>
                <div class="">
                    <button type="button" @click="submitForm" class="text-gray-900 bg-gradient-to-r from-purple-200 via-purple-400 to-purple-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <icon :icon="['fas', 'save']" class="mr-2" /> Lưu Dữ Liệu
                    </button>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from 'axios';
import InputUrlImage from '@/Components/InputUrlImage.vue';
import Editer from '@/Components/Editer.vue';

export default {
    components: {
        Link, AppLayout, InputUrlImage, Editer

    },

    data() {
        return {
            error: {
                url_avatar_full: '',
                url_avatar_icon: '',
                url_favicon: '',
                url_video: '',
                meta_title: '',
                meta_image: '',
                meta_desc: '',
                time_start: '',
                time_end: '',
                website: '',
                name: '',
                short_name: '',
                phone: '',
                hotline: '',
                mail: '',
                support_mail: '',
                slogan: '',
                sub_slogan: '',
                zalo: '',
                facebook: '',
                youtube: '',
                instagram: '',
                tiktok: '',
                linkedin: '',
                telegram: '',
                url_avatar_about: '',
                shortAbout: '',
                about: '',
                province: '',
                district: '',
                ward: '',
                address: '',
            }
        }
    },
    methods: {
        scrollToElement(nameElement) {
            // Sử dụng `ref` để lấy tham chiếu đến phần tử
            const element = this.$refs['scroll_' + nameElement];
            // Kiểm tra xem phần tử có tồn tại không
            if (element) {
                // Lấy kích thước của phần tử và cửa sổ trình duyệt
                const elementRect = element.getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;

                // Tính toán vị trí cuộn sao cho phần tử nằm giữa màn hình
                const scrollPosition = elementRect.top - (windowHeight / 2 - elementRect.height / 2);

                // Cuộn tới phần tử
                window.scrollTo({
                    top: scrollPosition,
                    behavior: 'smooth',
                });
            }
        },
        clearErrors() {
            this.error.url_avatar_full = "";
            this.error.url_avatar_icon = "";
            this.error.url_favicon = "";
            this.error.url_video = "";
            this.error.meta_title = "";
            this.error.meta_image = "";
            this.error.meta_desc = "";
            this.error.time_start = "";
            this.error.time_end = "";
            this.error.website = "";
            this.error.name = "";
            this.error.short_name = "";
            this.error.phone = "";
            this.error.hotline = "";
            this.error.mail = "";
            this.error.support_mail = "";
            this.error.slogan = "";
            this.error.sub_slogan = "";
            this.error.zalo = "";
            this.error.facebook = "";
            this.error.youtube = "";
            this.error.instagram = "";
            this.error.tiktok = "";
            this.error.linkedin = "";
            this.error.telegram = "";
            this.error.shortAbout = "";
            this.error.url_avatar_about = "";
            this.error.about = "";
            this.error.province = "";
            this.error.district = "";
            this.error.ward = "";
            this.error.address = "";

        },
        submitForm() {
            this.clearErrors();
            const url_avatar_full = this.$refs.get_url_avatar_full.url_image;
            const url_avatar_icon = this.$refs.get_url_avatar_icon.url_image;
            const url_favicon = this.$refs.get_url_favicon.url_image;
            const url_video = this.url_video;
            const name = this.name;
            const short_name = this.short_name;
            const slogan = this.slogan;
            const sub_slogan = this.sub_slogan;
            const website = this.website;
            const phone = this.phone;
            const hotline = this.hotline;
            const mail = this.mail;
            const support_mail = this.support_mail;
            const zalo = this.zalo;
            const facebook = this.facebook;
            const youtube = this.youtube;
            const instagram = this.instagram;
            const tiktok = this.tiktok;
            const linkedin = this.linkedin;
            const telegram = this.telegram;
            const province = this.province;
            const district = this.district;
            const ward = this.ward;
            const address = this.address;
            const url_avatar_about = this.$refs.get_url_avatar_about.url_image;
            const shortAbout = this.shortAbout;
            const about = this.$refs.getAbout.editer_data;
            const meta_title = this.meta_title;
            const meta_image = this.$refs.get_meta_image.url_image;
            const meta_desc = this.meta_desc;
            let loader = this.$loading.show();
            // simulate AJAX

            axios.post('', {
                url_avatar_full: url_avatar_full,
                url_avatar_icon: url_avatar_icon,
                url_favicon: url_favicon,
                url_video: url_video,
                name: name,
                short_name: short_name,
                slogan: slogan,
                sub_slogan: sub_slogan,
                website: website,
                phone: phone,
                hotline: hotline,
                mail: mail,
                support_mail: support_mail,
                zalo: zalo,
                facebook: facebook,
                youtube: youtube,
                instagram: instagram,
                tiktok: tiktok,
                linkedin: linkedin,
                telegram: telegram,



                province: province,
                district: district,
                ward: ward,
                address: address,
                url_avatar_about: url_avatar_about,
                shortAbout: shortAbout,
                about: about,
                meta_title: meta_title,
                meta_image: meta_image,
                meta_desc: meta_desc,
            })
                .then((response) => {

                    if (response.data.error) {
                        toast.error(response.data.error, {
                            autoClose: 3000,
                        });
                        this.scrollToElement(response.data.column);
                        this.error[response.data.column] = response.data.error;

                    } else {
                        toast.success("Uploads dữ liệu thành công", {
                            autoClose: 1000,
                        });
                    }
                    loader.hide();
                })
                .catch((error) => {
                    loader.hide();
                    toast.error("Xảy ra lỗi, vui lòng thử lại!", {
                        autoClose: 1000,
                    });
                    console.log(error);
                });
        }
    },


    setup() {
        const url_avatar_full = ref('');
        const url_avatar_icon = ref();
        const url_favicon = ref();
        const url_video = ref();
        const meta_title = ref();
        const meta_image = ref();
        const meta_desc = ref();
        const time_start = ref();
        const time_end = ref();
        const website = ref();
        const name = ref();
        const short_name = ref();
        const phone = ref();
        const hotline = ref();
        const mail = ref();
        const support_mail = ref();
        const slogan = ref();
        const sub_slogan = ref();
        const zalo = ref();
        const facebook = ref();
        const youtube = ref();
        const instagram = ref();
        const tiktok = ref();
        const linkedin = ref();
        const telegram = ref();





        const url_avatar_about = ref();
        const shortAbout = ref();
        const about = ref();
        const province = ref();
        const district = ref();
        const ward = ref();
        const address = ref();
        const dataProvince = ref([]);
        const dataDistrict = ref([]);
        const dataWard = ref([]);

        const dataCompany = usePage();

        url_avatar_full.value = dataCompany.props.data.url_avatar_full;
        url_avatar_icon.value = dataCompany.props.data.url_avatar_icon;
        url_favicon.value = dataCompany.props.data.url_favicon;
        url_video.value = dataCompany.props.data.url_video;
        meta_title.value = dataCompany.props.data.meta_title;
        meta_image.value = dataCompany.props.data.meta_image;
        meta_desc.value = dataCompany.props.data.meta_desc;
        time_start.value = dataCompany.props.data.time_start;
        time_end.value = dataCompany.props.data.time_end;
        website.value = dataCompany.props.data.website;
        name.value = dataCompany.props.data.name;
        short_name.value = dataCompany.props.data.short_name;
        phone.value = dataCompany.props.data.phone;
        hotline.value = dataCompany.props.data.hotline;
        mail.value = dataCompany.props.data.mail;
        support_mail.value = dataCompany.props.data.support_mail;
        slogan.value = dataCompany.props.data.slogan;
        sub_slogan.value = dataCompany.props.data.sub_slogan;
        zalo.value = dataCompany.props.data.zalo;
        facebook.value = dataCompany.props.data.facebook;
        youtube.value = dataCompany.props.data.youtube;
        instagram.value = dataCompany.props.data.instagram;
        tiktok.value = dataCompany.props.data.tiktok;
        linkedin.value = dataCompany.props.data.linkedin;
        telegram.value = dataCompany.props.data.telegram;






        url_avatar_about.value = dataCompany.props.data.url_avatar_about;
        shortAbout.value = dataCompany.props.data.shortAbout;
        about.value = dataCompany.props.data.about;
        province.value = dataCompany.props.data.province;
        district.value = dataCompany.props.data.district;
        ward.value = dataCompany.props.data.ward;
        address.value = dataCompany.props.data.address;
        dataProvince.value = dataCompany.props.dataProvince;
        dataDistrict.value = dataCompany.props.dataDistrict;
        dataWard.value = dataCompany.props.dataWard;





        const getDataDistrict = () => {
            const id = province.value;
            if (id) {
                axios.post('/get-data-district/' + id)
                    .then((response) => {
                        dataDistrict.value = response.data.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        }


        const getDataWard = () => {
            const id = district.value;

            if (id) {
                axios.post('/get-data-ward/' + id)
                    .then((response) => {
                        dataWard.value = response.data.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        }




        return {
            url_avatar_full,
            url_avatar_icon,
            url_favicon,
            url_video,
            meta_title,
            meta_image,
            meta_desc,
            time_start,
            time_end,
            website,
            name,
            short_name,
            phone,
            hotline,
            mail,
            support_mail,
            slogan,
            sub_slogan,
            zalo,
            facebook,
            youtube,
            instagram,
            tiktok,
            linkedin,
            telegram,
            url_avatar_about,
            shortAbout,
            about,
            province,
            district,
            ward,
            address,
            dataProvince,
            dataDistrict,
            dataWard,
            getDataDistrict,
            getDataWard
        }
    },
    // Các phương thức khác của component
}
</script>
