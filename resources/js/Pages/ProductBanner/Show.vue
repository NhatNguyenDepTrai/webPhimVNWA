<template>
    <AppLayout title="Banner">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Banner
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
                        <button @click="showModalProduct" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded ">
                            <icon :icon="['fas', 'plus']" /> Thêm banner

                        </button>

                    </div>
                    <DialogModal :show="isModalProduct" max-width="full">
                        <template #title>
                            <div class="flex items-center justify-between">
                                <h3>
                                    Danh sách sản phẩm

                                </h3>
                                <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="isModalProduct = false">
                                    Đóng
                                </button>
                            </div>
                        </template>

                        <template #content>
                            <div class="mb-2">
                                <div class="flex items-center justify-end">
                                    <span class="me-3">Tìm kiếm :</span>
                                    <select v-model="modalProduct.searchField">
                                        <option value="name">Tên</option>
                                        <option value="full_name">Tên thực</option>

                                    </select>
                                    <input type="text" v-model="modalProduct.searchValue" placeholder="Tìm kiếm">
                                </div>

                            </div>
                            <div v-if="modalProduct.itemsSelected.length > 0">


                                <div class="flex items-center justify-start flex-wrap mb-3">
                                    <div>Danh sách chọn: </div>
                                    <span v-for="item in modalProduct.itemsSelected" class="ms-3 inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ item.name }}</span>

                                </div>
                                <div class="text-end">
                                    <button @click="addProductInProductBanner" class="text-white px-3 py-2 bg-blue-500 mb-3">Thêm dữ liệu
                                        <icon :icon="['fas', 'save']" />
                                    </button>
                                </div>
                            </div>
                            <div>
                                <DataTable :headers="modalProduct.headers" :search-field="modalProduct.searchField" :search-value="modalProduct.searchValue" :items="modalProduct.dataTable" buttons-pagination show-index v-model:items-selected="modalProduct.itemsSelected">



                                    <template #item-product="{ name, full_name, url_avatar }">

                                        <div class="py-3 flex items-center justify-start">
                                            <img :src="url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 xl:block hidden">
                                            <div>
                                                <span class=" block text-sm font-bold">{{ name }}</span>
                                                <span class=" block text-sm font-bold text-black/50">{{ full_name }}</span>
                                            </div>
                                        </div>
                                    </template>
                                    <template #item-url_bg="{ url_bg }">

                                        <img :src="url_bg" alt="" class="h-28 w-auto">
                                    </template>
                                </DataTable>

                            </div>
                        </template>

                        <template #footer>

                            <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="isModalProduct = false">
                                Đóng
                            </button>

                        </template>
                    </DialogModal>
                    <div class="my-2 py-10">
                        <DataTable :headers="headers" :items="dataPage" buttons-pagination show-index v-model:items-selected="itemsSelected">

                            <template #item-product="{ product }">
                                <div class="py-3 flex items-center justify-start">
                                    <img :src="product.url_bg" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">
                                    <div>
                                        <span class=" block text-sm font-bold">{{ product.name }}</span>
                                        <span class=" block text-xs text-black/50 font-bold">{{ product.full_name }}</span>
                                    </div>
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
                                    <button class="bg-red-600 text-white px-2 py-1 rounded-md mr-5" @click="showModalDeleteItem(id, name)">
                                        <icon :icon="['fas', 'x']" />
                                    </button>

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
            isModalProduct: false,
            inputSearchName: false,
            checkboxDeleteToTrash: false,
            itemsDelete: [],
            modalDelete: false,
            itemsSelected: [],
            headers: [
                { text: "Sản Phẩm", value: "product" },
                { text: "Thứ tự xuất hiện", value: "ord", sortable: true },
                { text: "Ngày tạo", value: "create_time" },
                { text: "Trạng thái", value: "status" },
                { text: "Hành động", value: "operation" },
            ],
            modalProduct: {
                headers: [
                    { text: "Tên dữ liệu", value: "name" },
                    { text: "Ảnh Nền", value: "url_bg" },


                ],
                dataTable: [],
                searchField: 'name',
                searchValue: '',
                itemsSelected: [],

            }

        };
    },
    methods: {
        showModalProduct() {
            axios.post('product-banner/load-data-product')
                .then((response) => {
                    this.modalProduct.dataTable = response.data.data;
                    this.isModalProduct = true;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addProductInProductBanner() {
            axios.post('product-banner/add-product-in-product-banner', {
                dataProduct: this.modalProduct.itemsSelected
            })
                .then((response) => {
                    this.isModalProduct = false;
                    this.loadData();


                })
                .catch((error) => {
                    console.log(error);
                });
        },
        closeModal() {
            this.modalDelete = false;
        },
        changeORD(id, name, event) {
            if (event.target.value) {


                axios.post('/change-ord', {
                    tb: 'product_banners',
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
                    tb: 'product_banners',
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
                    tb: 'product_banners',
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
            axios.post('product-banner/load-data-table')
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
            dataPage, checkedStatusItems, loadData, searchDataTable, searchName
        }
    },
    // Các phương thức khác của component
}
</script>
