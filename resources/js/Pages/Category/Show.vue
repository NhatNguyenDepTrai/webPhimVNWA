<template>
    <AppLayout title="Danh Mục">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Danh Mục
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pt-8 pb-12 px-2">
                    <div class="">
                        <DataTable :headers="headers" :items="dataPage" buttons-pagination show-index>

                            <template #item-name="{ name, url_avatar }">
                                <div class="py-3 flex items-center justify-start">
                                    <span class=" block text-sm font-bold">{{ name }}</span>
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

                            <template #item-ord="{ id, name, ord }">
                                <div class="py-3 flex items-center justify-center">
                                    <input type="number" class=" text-black rounded  text-center px-1" :value="ord" style="max-width: 50px;" @input="changeORD(id, name, $event)">
                                </div>
                            </template>
                            <template #item-operation="{ id, name }">
                                <div class="py-3 flex items-center justify-center">

                                    <Link :href="route('Category.Edit', id)" class="bg-yellow-600 text-white px-2 py-1 rounded-md mr-5">
                                    <icon :icon="['fas', 'pen-to-square']" />
                                    </Link>
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
                    <div class="max-w-xs">
                        <div class="flex items-center h-6 mt-3 cursor-pointer  ">
                            <input id="bordered-checkbox-1" :checked="checkboxDeleteToTrash" @click="checkboxDeleteToTrash = !checkboxDeleteToTrash" type="checkbox" value="" name="bordered-checkbox" class="  cursor-pointer w-4 h-4 text-blue-600 bg-gray-100  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">
                            <label for="bordered-checkbox-1" class=" cursor-pointer w-full py-4 ms-2 text-sm font-medium text-black ">Đưa vào thùng rác</label>
                        </div>

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
            inputSearchName: false,
            checkboxDeleteToTrash: true,
            itemsDelete: [],
            modalDelete: false,
            itemsSelected: [],
            headers: [
                { text: "Tên dữ liệu", value: "name" },
                { text: "Thứ tự xuất hiện", value: "ord", sortable: true },
                { text: "Ngày cập nhập", value: "update_time" },
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
                    tb: 'categories',
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
                    tb: 'categories',
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
                    tb: 'categories',
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
                    tb: 'categories',
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

        const trashCount = ref();


        trashCount.value = data.props.trashCountNumber;

        dataAll.value = data.props.data;
        dataAll.value = data.props.data.map(item => {
            return { ...item, status: item.status === 1 ? true : false };
        });

        const loadData = () => {
            axios.post('category/load-data-table')
                .then((response) => {
                    let returnData = response.data;
                    dataPage.value = returnData.data;
                    dataPage.value = returnData.data.map(item => {
                        return { ...item, status: item.status === 1 ? true : false };
                    });

                    trashCount.value = returnData.trashCount;
                    console.log(trashCount.value)
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
            dataPage, checkedStatusItems, checkedHighlightItems, trashCount, loadData, searchDataTable, searchName
        }
    },
    // Các phương thức khác của component
}
</script>
