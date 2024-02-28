

<template>
    <AppLayout title="Thêm Banner">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
                Thêm Banner
            </h2>
        </template>
        <div class="overflow-hidden  px-5 mb-3 ">
            <div class="w-100  p-1 flex justify-between items-center">
                <div class="  ">
                    <Link :href="route('Process')" class="text-dark-700 hover:text-purple-900 font-bold underline decoration-1">
                    <icon :icon="['fas', 'arrow-left']" /> Trở về
                    </Link>
                </div>
                <div class="">
                    <button type="button" @click="submitForm" class="text-gray-900 bg-gradient-to-r from-purple-200 via-purple-400 to-purple-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <icon :icon="['fas', 'save']" class="mr-2" /> Lưu Dữ Liệu
                    </button>
                </div>
            </div>
        </div>
        <div class="pb-12">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-12 relative">

                    <div class="col-span-6 p-2">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 p">
                            <div class="mb-3">
                                <label for="name" class="block mb-2 font-bold text-base text-gray-900 dark:text-dark">Tên dữ liệu</label>
                                <input type="text" v-model="name" placeholder="John" id="name" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                                <span class="text-red-600 text-xs" ref="scroll_name">{{ error.name }}</span>



                            </div>
                            <div class="mb-3">
                                <label for="name" class="block mb-2 font-bold text-base text-gray-900 dark:text-dark">Mô tả dữ liệu</label>
                                <textarea v-model="desc" cols="30" rows="10" placeholder="Nhập mô tả" class="bg-gray-50 border text-base border-gray-300 text-gray-900  rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-purple-500 dark:focus:border-purple-500">

                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <div class="grid grid-cols-12">
                            <div class="col-span-6 p-2">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 p">
                                    <div class="mb-3">
                                        <label for="name" class="block mb-2 font-bold text-base text-gray-900 dark:text-dark">Ảnh đại diện</label>

                                        <InputUrlImage ref="url_avatar" />
                                        <span class="text-red-600 text-xs" ref="scroll_url_avatar">{{ error.url_avatar }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 p-2">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 mb-3 p">
                                    <div class="mb-3">
                                        <label for="name" class="block mb-2 font-bold text-base text-gray-900 dark:text-dark">Ảnh đại diện mobile</label>
                                        <span class="block mb-2 text-slate-600 text-sm">Không nhập sẽ tự động lấy đường dẫn ảnh đại diện </span>
                                        <InputUrlImage ref="url_avatar_mobile" />
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>






                </div>

            </div>
        </div>
        <div class="bg-slate-900 overflow-hidden shadow-xl  p-2  ">
            <div class="w-100  p-1 flex justify-between items-center">
                <div class=" text-white ">
                    <Link :href="route('Process')" class="text-dark-700 hover:text-purple-900 font-bold underline decoration-1">
                    <icon :icon="['fas', 'arrow-left']" /> Trở về
                    </Link>
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
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import InputUrlImage from '@/Components/InputUrlImage.vue';
import ButtonMutipleImage from '@/Components/ButtonMutipleImage.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';



export default {

    name: 'Create Blog Tag',
    components: {
        InputUrlImage, ButtonMutipleImage, AppLayout, Link
    },

    data() {
        return {
            name: '',
            desc: '',

            error: {
                url_avatar: '',
                name: '',
                desc: '',

            }
        }
    },

    methods: {


        clearErrors() {
            this.error.url_avatar = "";
            this.error.name = "";
            this.error.desc = "";

        },
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

        submitForm() {

            this.clearErrors();
            const url_avatar = this.$refs.url_avatar.url_image;

            const url_avatar_mobile = this.$refs.url_avatar_mobile.url_image;

            const name = this.name;
            const desc = this.desc;


            axios.post('', {
                url_avatar: url_avatar,
                url_avatar_mobile: url_avatar_mobile,
                name: name,
                desc: desc,

            })
                .then((response) => {
                    if (response.data.error) {
                        toast.error(response.data.error, {
                            autoClose: 3000,
                        });
                        // this.scrollToElement(response.data.column);
                        this.error[response.data.column] = response.data.error;

                    } else {
                        toast.success("Uploads dữ liệu thành công", {
                            autoClose: 1000,
                        });
                    }

                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },

}
</script>

