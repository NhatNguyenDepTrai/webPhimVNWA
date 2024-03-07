<template>
    <AppLayout title="Danh Sách Liên Kết">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Danh Sách Liên Kết
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pt-8 pb-12 px-2">
                    <div class="float-left">
                        <button :disabled="itemsSelected.length <= 0" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="showModalDeleteMutipleItem">
                            <icon :icon="['fas', 'x']" class="mr-1" /> Xóa dữ liệu chọn
                        </button>
                    </div>
                    <div class="float-right text-xs uppercase">
                        <Link :href="route('LinkCreate')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded ">
                        <icon :icon="['fas', 'plus']" /> Thêm dữ liệu
                        </Link>
                    </div>

                    <div class="my-2 py-10">
                        <DataTable :headers="headers" :items="dataPage" buttons-pagination show-index v-model:items-selected="itemsSelected">
                            <template #header-name="header">
                                <div class="filter-column  flex items-center">
                                    <div>
                                        <button class="p-2 text-center  mr-2 border-none " :class="{ 'bg-purple-400 text-white': searchName.trim() }" @click="inputSearchName = !inputSearchName">
                                            <icon :icon="['fas', 'filter']" />
                                        </button>
                                        <div class="filter-menu absolute z-30 top-9 w-52 flex items-center justify-center" v-if="inputSearchName">
                                            <input style="height: 30px;" type="text" class="text-xs h-8 border-r-0" v-model="searchName" @input="searchDataTable()" placeholder="Tìm kiếm" />

                                            <button style="height: 30px; width: 30px;" class="bg-black text-white hover:text-red-400" @click="inputSearchName = false">
                                                <icon :icon="['fas', 'x']" />
                                            </button>
                                        </div>
                                    </div>
                                    {{ header.text }}

                                </div>
                            </template>
                            <template #item-name="{ name, url_avatar }">
                                <div class="py-3 flex items-center justify-start">
                                    <img :src="appFileUrl+'/'+url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 block"> <span class=" block text-sm font-bold">{{ name }}</span>
                                </div>
                            </template>
                            <template #item-status="{ id, status }">
                                <div class="flex items-center cursor-pointer">
                                    <input type="checkbox" :id="'statusCheckbox-' + id" v-model="checkedStatusItems[id]" class="hidden" @change="handleStatusChange(id, status)" />
                                    <label :for="'statusCheckbox-' + id" class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <div class="toggle-path bg-gray-300 w-9 h-5 rounded-full p-0">
                                                <div class="toggle-circle  w-5 h-5 rounded-full shadow-md" :class="{ 'transform translate-x-full bg-purple-500': checkedStatusItems[id], 'bg-white': !checkedStatusItems[id] }"></div>
                                            </div>
                                        </div>

                                    </label>
                                </div>
                            </template>
                            <template #item-highlight="{ id, highlight }">
                                <div class="flex items-center cursor-pointer justify-center">
                                    <input type="checkbox" :id="'highlightCheckbox-' + id" v-model="checkedHighlightItems[id]" class="hidden" @change="handleHighlightChange(id, highlight)" />
                                    <label :for="'highlightCheckbox-' + id" class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <div class="toggle-path bg-gray-300 w-9 h-5 rounded-full p-0">
                                                <div class="toggle-circle  w-5 h-5 rounded-full shadow-md" :class="{ 'transform translate-x-full bg-purple-500': checkedHighlightItems[id], 'bg-white': !checkedHighlightItems[id] }"></div>
                                            </div>
                                        </div>

                                    </label>
                                </div>
                            </template>
                            <template #item-ord="{ id, name, ord }">
                                <div class="py-3 flex items-center justify-center">
                                    <input type="number" class=" text-black rounded  text-center px-1" :value="ord" style="max-width: 50px;" @input="changeORD(id, name, $event)">
                                </div>
                            </template>
                            <template #item-operation="{ id, name }">
                                <div class="py-3 flex items-center justify-center">
                                    <button class="bg-red-600 text-white px-2 py-1 rounded-md mr-5" @click="showModalDeleteItem(id, name)">
                                        <icon :icon="['fas', 'x']" />
                                    </button>
                                    <Link :href="route('LinkEdit', id)" class="bg-yellow-600 text-white px-2 py-1 rounded-md mr-5">
                                    <icon :icon="['fas', 'pen-to-square']" />
                                    </Link>
                                </div>
                            </template>
                            <template #expand="item">
                                <div class="py-4  px-3 bg-neutral-950 text-white">

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
                                            Liên kết
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <a class="text-sky-500 underline decoration-1" :href="item.value" target="_blank">{{ item.value }}</a>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Ảnh dữ liệu
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <div class="flex">
                                                <div>
                                                    <img :src="appFileUrl+'/'+item.url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">
                                                    Avatar Desktop
                                                </div>
                                                <div class="ml-10">
                                                    <img :src="appFileUrl+'/'+item.url_avatar_mobile" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">
                                                    Avatar Mobile
                                                </div>
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

                <div class="mt-3 mb-1">
                    <div class="text-xs text-gray-600">Lưu ý :
                        <ul class="pl-4">
                            <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Các dữ liệu được xóa sẽ tự động đưa vào thùng rác </li>
                            <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Các dữ liệu trong thùng rác được tự động xóa sau 30 </li>
                            <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Muốn xóa trực tiếp hãy bỏ chọn checkbox bên dưới</li>
                        </ul>
                    </div>

                </div>
            </template>

            <template #footer>


                <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="deleteItems">
                    Xóa dữ liệu
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
import 'vue3-toastify/dist/index.css';
import axios from 'axios';

export default {
    props: {
    },

    components: {
        Link, AppLayout,
        Welcome, DialogModal,
    },
    data() {
        return {
        appFileUrl:import.meta.env.VITE_API_FILE,
            inputSearchName: false,
            checkboxDeleteToTrash: false,
            itemsDelete: [],
            modalDelete: false,
            itemsSelected: [],
            headers: [
                { text: "ORD", value: "ord" },
                { text: "Tên dữ liệu", value: "name" },

                { text: "Ngày tạo", value: "create_time" },
                { text: "Nổi bật", value: "highlight" },
                { text: "Trạng thái", value: "status" },
                { text: "Hành động", value: "operation" },
            ],

        };
    },
    methods: {

        closeModal() {
            this.modalDelete = false;
        },
        changeORD(id, name, event) {
            if (event.target.value) {


                axios.post('/change-ord', {
                    tb: 'links',
                    id: id,
                    value: event.target.value,
                })
                    .then((response) => {
                        var toastMess = "Cập nhập ORD cho " + name + " thành " + event.target.value + " thành công !";
                        toast.success(toastMess, {
                            autoClose: 1000,
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            else {
                toast.error("ORD không được bỏ trống", {
                    autoClose: 1000,
                });
            }
        },

        async deleteItems() {


            try {
                const dataDelete = [];
                this.itemsDelete.forEach(element => {
                    dataDelete.push(element.id)

                });
                const checkboxDeleteToTrash = this.checkboxDeleteToTrash;
                // Gửi POST request tới server để thay đổi giá trị status
                await axios.post('/delete-items', {
                    tb: 'links',
                    dataId: dataDelete,
                    trash: checkboxDeleteToTrash,
                }).then(response => {
                    const type = response.data.type;
                    if (type === 'success') {
                        this.loadData();
                        this.modalDelete = false;
                        toast.success(response.data.mess, {
                            autoClose: 1500,
                        });
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
                    });


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
        async handleStatusChange(id, currentStatus) {
            try {
                const newStatus = !currentStatus ? 1 : 0;
                // Gửi POST request tới server để thay đổi giá trị status
                const response = await axios.post('/change-status', {
                    tb: 'links',
                    id: id,
                    status: newStatus, // Chuyển đổi giá trị status
                });
                if (newStatus == 1) {
                    toast.success("Hiện dữ liệu thành công", {
                        autoClose: 1000,
                    });
                } else {
                    toast.success("Ẩn dữ liệu thành công", {
                        autoClose: 1000,
                    });
                }
            } catch (error) {
                console.error('Error while changing status:', error);
            }
        },
        async handleHighlightChange(id, highlight) {

            try {
                const newHighlight = !highlight ? 1 : 0;
                // Gửi POST request tới server để thay đổi giá trị status
                const response = await axios.post('/change-highlight', {
                    tb: 'links',
                    id: id,
                    highlight: newHighlight, // Chuyển đổi giá trị status
                });
                toast.success("Chỉnh sửa hightlight thành công!", {
                    autoClose: 1000,
                });
            } catch (error) {
                console.error('Error while changing status:', error);
            }
        },
    },

    setup() {
        const dataAll = ref([]);
        const dataPage = ref([]);
        const data = usePage();



        dataAll.value = data.props.data;
        dataAll.value = data.props.data.map(item => {
            return { ...item, status: item.status === 1 ? true : false };
        });

        const loadData = () => {
            axios.post('tag-blog/load-data-table')
                .then((response) => {
                    let returnData = response.data;
                    dataPage.value = returnData.data;
                    dataPage.value = returnData.data.map(item => {
                        return { ...item, status: item.status === 1 ? true : false };
                    });


                })
                .catch((error) => {
                    console.log(error);
                });
        }

        const checkedStatusItems = ref([]);
        dataAll.value.forEach(element => {
            checkedStatusItems.value[element.id] = element.status;
        });
        const checkedHighlightItems = ref([]);
        dataAll.value.forEach(element => {
            checkedHighlightItems.value[element.id] = element.highlight;
        });

        dataPage.value = dataAll.value;
        const searchName = ref('');
        const searchDataTable = () => {
            if (searchName.value) {
                const searchResults = dataAll.value.filter(item => item.name.trim().toLowerCase().includes(searchName.value.trim().toLowerCase()));
                dataPage.value = searchResults;
            } else {
                dataPage.value = dataAll.value;

            }

        }


        return {
            dataPage, checkedStatusItems, checkedHighlightItems, loadData, searchDataTable, searchName
        }
    },
    // Các phương thức khác của component
}
</script>
