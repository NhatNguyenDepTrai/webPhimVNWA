<template>
    <AppLayout title="Thùng Rác - Danh Mục | VNWA ADMIN">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Thùng rác Danh Mục
            </h2>
            <span class="text-gray-500 italic">Các dữ liệu trong thùng rác sẽ tự động xóa sau 30 ngày</span>
        </template>

        <div class="py-2">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pt-8 pb-12 px-2">
                    <div class="float-left">

                        <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="showModalRestoreMutipleItem">
                            <icon :icon="['fas', 'rotate-left']" class="mr-1" /> Khôi phục dữ liệu chọn
                        </button>
                        <button :disabled="itemsSelected.length <= 0" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="showModalDeleteMutipleItem">
                            <icon :icon="['fas', 'x']" class="mr-1" /> Xóa dữ liệu chọn
                        </button>
                    </div>
                    <div class="float-right text-xs uppercase">
                        <Link :href="route('CategoryBlog')" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4">
                        <icon :icon="['fas', 'arrow-left']" class="mr-1" /> Trở về
                        </Link>
                    </div>

                    <div class="my-2 py-10">
                        <DataTable :headers="headers" :items="dataPage" buttons-pagination show-index v-model:items-selected="itemsSelected">
                            <template #item-name="{ name, url_avatar }">
                                <div class="py-3 flex items-center justify-start">
                                    <img :src="url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 block"> <span class=" block text-sm font-bold">{{ name }}</span>
                                </div>
                            </template>



                            <template #item-operation="{ id, name }">
                                <div class="py-3 flex items-center justify-center">
                                    <button class="bg-green-600 text-white px-2 py-1 rounded-md mr-5" @click="showModalRestoreItem(id, name)">
                                        <icon :icon="['fas', 'rotate-left']" />
                                    </button>
                                    <button class="bg-red-600 text-white px-2 py-1 rounded-md mr-5" @click="showModalDeleteItem(id, name)">
                                        <icon :icon="['fas', 'x']" />
                                    </button>
                                </div>
                            </template>
                            <template #expand="item">
                                <div class="py-4  px-3 bg-neutral-950 text-white">
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Meta SEO
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <div class=" mx-auto   border rounded-lg shadow-md overflow-hidden" style="max-width: 300px;">



                                                <!-- Ảnh xem trước -->
                                                <div class=" p-1 bg-white">
                                                    <img :src="item.meta_image" alt="Vinawebapp.com" class="w-full h-auto rounded-md">
                                                </div>
                                                <div class="bg-gray-200 px-4 py-1 ">
                                                    <div class="text-gray-500 uppercase  ">Vinawebapp.com</div>
                                                    <!-- Tiêu đề liên kết -->
                                                    <div class="text-xl font-semibold mb-1 text-black">{{ item.meta_title }}</div>

                                                    <!-- Mô tả liên kết -->
                                                    <div class="text-gray-600 mb-2">{{ item.meta_desc }}</div>
                                                </div>

                                                <!-- URL liên kết -->



                                            </div>

                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Tên dữ liệu
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <span class="text-xs">{{ item.name }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Slug
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <span class="text-xs">{{ item.slug }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Ảnh dữ liệu
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <div class="flex">
                                                <div>
                                                    <img :src="item.url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">
                                                    Avatar Desktop
                                                </div>
                                                <div class="ml-10">
                                                    <img :src="item.url_avatar_mobile" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">
                                                    Avatar Mobile
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Ảnh kèm theo
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <div class="flex" v-if="item.list_images.length > 0">
                                                <div v-for="image in item.list_images ">
                                                    <img :src="image.url_image" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">
                                                </div>
                                            </div>
                                            <div v-else>
                                                Rỗng
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Mô tả
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <span class="text-xs"> {{ item.desc }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Nội dung
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <div v-html="item.content"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
        <DialogModal :show="modalDelete" @close="closeModal">
            <template #title>
                Xóa dữ liệu
            </template>

            <template #content>
                Chắc chắn xóa các dữ liệu này!
                <div class="mt-4">
                </div>
                <div v-if="itemsDelete.length > 0">
                    <div class="flex items-center" v-for="item in itemsDelete">
                        <icon :icon="['fas', 'x']" class="text-red-600 mr-1" /> <span>{{ item.name }}</span>
                    </div>
                </div>
                <div v-else>
                    <span class="text-center text-red-800 font-bold">Vui lòng chọn một dữ liệu</span>
                </div>
                <div class="mt-3 mb-1">
                    <div class="text-xs text-gray-600">Lưu ý :
                        <ul class="pl-4">
                            <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Các dữ liệu được xóa vĩnh viễn không thể khôi phục </li>
                        </ul>
                    </div>

                </div>
            </template>

            <template #footer>


                <button v-if="itemsDelete.length > 0" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="deleteItems">
                    Xóa dữ liệu
                </button>
                <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="closeModal">
                    Hủy lệnh
                </button>
            </template>
        </DialogModal>

        <DialogModal :show="modalRestore" @close="closeModal">
            <template #title>
                Khôi phục dữ liệu
            </template>

            <template #content>
                Bạn muốn khôi phục các dữ liệu này?
                <div class="mt-4">
                </div>
                <div v-if="itemsRestore.length > 0">
                    <div class="flex items-center" v-for="item in itemsRestore">
                        <icon :icon="['fas', 'x']" class="text-red-600 mr-1" /> <span>{{ item.name }}</span>
                    </div>
                </div>
                <div v-else>
                    <span class="text-center text-red-800 font-bold">Vui lòng chọn một dữ liệu</span>
                </div>

            </template>

            <template #footer>


                <button v-if="itemsRestore.length > 0" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="restoreItems">
                    Khôi phục dữ liệu
                </button>
                <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="closeModal">
                    Hủy lệnh
                </button>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import { toast } from 'vue3-toastify';


export default {
    props: {
    },

    components: {
        Link, AppLayout,
        Welcome, DialogModal,
    },
    data() {
        return {
            checkboxDeleteToTrash: false,
            itemsRestore: [],
            itemsDelete: [],
            modalDelete: false,
            modalRestore: false,
            itemsSelected: [],
            headers: [
                { text: "Tên dữ liệu", value: "name" },

                { text: " Đưa Vào Thùng Rác", value: "delete_at" },
                // { text: "Xóa Hoàn Toàn", value: "delete_time" },
                { text: "Khôi phục", value: "operation" },
            ],
        };
    },
    methods: {
        closeModal() {
            this.modalDelete = false;
            this.modalRestore = false;
        },
        async deleteItems() {
            try {
                const dataDelete = [];
                this.itemsDelete.forEach(element => {
                    dataDelete.push(element.id)

                });
                const checkboxDeleteToTrash = this.checkboxDeleteToTrash;
                // Gửi POST request tới server để thay đổi giá trị status




                const response = await axios.post('/delete-items', {
                    tb: 'category_blogs',
                    dataId: dataDelete,
                    trash: checkboxDeleteToTrash, // Chuyển đổi giá trị status
                }).then(response => {
                    const type = response.data.type;
                    if (type === 'success') {
                        location.reload();
                    } else if (type === 'error') {
                        console.error(response.data.mess);
                        toast.error('Không thể xóa danh mục, vì còn có các bài viết phụ thuộc', {
                            autoClose: 1500,
                        });
                    }

                })
                    .catch(e => {
                        console.log('e');
                        console.error(e);
                        // this.errors.push(e)
                    });;
            } catch (error) {
                console.error('Error while changing status:', error);
            }
        },

        showModalDeleteMutipleItem() {
            this.itemsDelete = [];
            this.itemsSelected.forEach(element => {
                // this.itemsDelete['id'] = element.id;
                // this.itemsDelete[id] = element.name;
                this.itemsDelete.push({ id: element.id, name: element.name })

            });
            console.log(this.itemsDelete)
            this.modalDelete = true;

        },
        showModalDeleteItem(deleteId, deleteName) {
            this.itemsDelete = [];
            this.itemsDelete.push({ id: deleteId, name: deleteName })
            this.modalDelete = true;

        },
        showModalRestoreMutipleItem() {
            this.itemsRestore = [];
            this.itemsSelected.forEach(element => {
                this.itemsRestore.push({ id: element.id, name: element.name })

            });
            console.log(this.itemsDelete)
            this.modalRestore = true;

        },
        showModalRestoreItem(dataId, dataName) {
            this.itemsRestore = [];
            this.itemsRestore.push({ id: dataId, name: dataName })
            this.modalRestore = true;
        },
        async restoreItems() {
            try {
                const dataRestore = [];
                this.itemsRestore.forEach(element => {
                    dataRestore.push(element.id)

                });

                const response = await axios.post('/restore-items', {
                    tb: 'category_blogs',
                    dataId: dataRestore,

                });
                location.reload();
            } catch (error) {
                console.error('Error while changing status:', error);
            }
        },
        async handleStatusChange(id, currentStatus) {
            try {
                const newStatus = !currentStatus ? 1 : 0;
                // Gửi POST request tới server để thay đổi giá trị status
                const response = await axios.post('/change-status', {
                    tb: 'category_blogs',
                    id: id,
                    status: newStatus, // Chuyển đổi giá trị status
                });




            } catch (error) {
                console.error('Error while changing status:', error);
            }
        },
        async handleHighlightChange(id, highlight) {

            try {
                const newHighlight = !highlight ? 1 : 0;
                // Gửi POST request tới server để thay đổi giá trị status
                const response = await axios.post('/change-highlight', {
                    tb: 'category_blogs',
                    id: id,
                    highlight: newHighlight, // Chuyển đổi giá trị status
                });
            } catch (error) {
                console.error('Error while changing status:', error);
            }
        },
    },
    setup() {
        const dataPage = ref([]);
        const data = usePage();
        const trashCount = data.props.trashCount;
        dataPage.value = data.props.data;
        dataPage.value = data.props.data.map(item => {
            return { ...item, status: item.status === 1 ? true : false };
        });
        const checkedStatusItems = ref([]);
        dataPage.value.forEach(element => {
            checkedStatusItems.value[element.id] = element.status;
        });
        const checkedHighlightItems = ref([]);
        dataPage.value.forEach(element => {
            checkedHighlightItems.value[element.id] = element.highlight;
        });
        return {
            dataPage, checkedStatusItems, checkedHighlightItems, trashCount
        }
    },
    // Các phương thức khác của component
}
</script>
