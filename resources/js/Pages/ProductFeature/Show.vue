<template>
    <AppLayout title="Danh sách Phim Lẻ">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Danh sách Phim Lẻ
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
                        <Link :href="route('ProductFeature.Trash')" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4">
                        <icon :icon="['fas', 'trash']" class="mr-3" />Thùng rác ({{ trashCount }})
                        </Link>
                        <Link :href="route('ProductFeature.Create')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded ">
                        <icon :icon="['fas', 'plus']" /> Thêm dữ liệu
                        </Link>
                    </div>

                    <div class="my-2 py-10">
                        <div class="mb-2">
                            <div class="flex items-center justify-end">
                                <span class="me-3">Tìm kiếm :</span>
                                <select v-model="searchField">
                                    <option value="name">Tên</option>
                                    <option value="nameNation">Quốc Gia</option>
                                    <option value="nameYear">Năm Phát Hành</option>
                                </select>
                                <input type="text" v-model="searchValue" placeholder="Tìm kiếm">
                            </div>

                        </div>
                        <DataTable :headers="headers" :search-field="searchField" :search-value="searchValue" :items="dataPage" buttons-pagination show-index v-model:items-selected="itemsSelected">



                            <template #item-name="{ name, full_name, url_avatar }">
                                <div class="py-3 flex items-center justify-start">
                                    <img :src="url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 xl:block hidden">
                                    <div>
                                        <span class=" block text-sm font-bold">{{ name }}</span>
                                        <span class=" block text-sm font-bold text-black/50">{{ full_name }}</span>
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
                                    <Link :href="route('ProductFeature.edit', id)" class="bg-yellow-600 text-white px-2 py-1 rounded-md mr-5">
                                    <icon :icon="['fas', 'pen-to-square']" />
                                    </Link>
                                </div>
                            </template>


                            <template #item-episode="{ episodes, id, url_avatar, full_name, name }">
                                <div class="flex items-center justify-center">

                                    <div v-if="episodes.length <= 0">
                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">COMING SOON</span>
                                    </div>
                                    <div v-else>

                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300"> {{ episodes[episodes.length - 1].name }}</span>
                                    </div>
                                    <div class="ms-5">

                                        <button @click="showListEpisode(id, url_avatar, full_name, name)" class="py-1 px-2 rounded bg-gray-600 text-white hover:text-white/80">
                                            <icon icon="clipboard-list" class="h-5" />
                                        </button>

                                    </div>
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
                                            <img :src="item.url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 block">

                                        </div>
                                    </div>
                                    <div class="grid grid-cols-12 mb-3 w-full">
                                        <div class="col-span-3 p-2 border flex items-center font-bold">
                                            Thể loại
                                        </div>
                                        <div class="col-span-9 p-2 border">
                                            <div class="" v-if="item.types.length > 0">

                                                <span v-for="type_detail in item.types " class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ type_detail.name }}</span>

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
                                            <div v-html="item.desc"></div>
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
        <DialogModal :show="isModalEpisode" max-width="full">
            <template #title>
                <div class="flex items-center justify-between">
                    <h3>
                        Danh sách tập phim {{ episode.dataProduct.name }}

                    </h3>
                    <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="isModalEpisode = false">
                        Đóng
                    </button>
                </div>
            </template>

            <template #content>
                <div class="flex justify-between items-center">
                    <div class="flex">
                        <img :src="episode.dataProduct.url_avatar" alt="vinawebapp.com" class="w-20 h-auto mr-3 xl:block hidden">
                        <div>
                            <span class=" block text-sm font-bold">{{ episode.dataProduct.name }}</span>
                            <span class=" block text-sm font-bold text-black/50">{{ episode.dataProduct.full_name }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold text-lg">Thêm tập phim : </span>
                        <input type="text" v-model="episode.createItem.name" placeholder="Nhập tên tập phim" class="mx-5" />
                        <button @click="episodeCreateItem(episode.dataProduct.id)" class="px-3 py-2 bg-green-500 text-black/60 hover:bg-green-500/70">Thêm</button>

                    </div>
                </div>
                <div>
                    <div class="my-3">
                        <div class="border flex items-center justify-center py-3" v-if="episode.isEditing">
                            <input type="text" hidden disabled v-model="episode.editingItem.id" />
                            Chỉnh sửa tên tập: <input type="text" v-model="episode.editingItem.name" class="text-black/90 mx-3" />
                            <br />
                            <button @click="episodeUpdateItem(episode.dataProduct.id)" class="bg-yellow-500 text-xl text-white/80 hover:text-black/80 px-3 py-1">Lưu</button>
                        </div>
                    </div>
                    <DataTable :headers="episode.headers" :items="episode.dataTable" buttons-pagination show-index>
                        <template #item-name="{ name, id }">
                            {{ name }}
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
                                <button class="bg-red-600 text-white px-2 py-1 rounded-md mr-5" @click="episodeDeleteItem(id, episode.dataProduct.id)">
                                    <icon :icon="['fas', 'x']" />
                                </button>
                                <button class="bg-yellow-600 text-white px-2 py-1 rounded-md mr-5" @click="episodeShowEditItem(id, name)">
                                    <icon :icon="['fas', 'pen-to-square']" />

                                </button>

                            </div>
                        </template>
                        <template #expand="item">
                            <div class="p-4  px-3 bg-neutral-950 text-white">
                                <div class="w-full py-3 text-xl text-white/90 uppercase font-bold text-center">
                                    Danh sách server
                                </div>
                                <div class="bg-white/90 text-black">
                                    <div class="py-2 px-5 flex items-center justify-end">
                                        <select v-model="episode.server.createItem.type">
                                            <option value="iframe">iframe</option>
                                        </select>
                                        <input v-model="episode.server.createItem.embed_url" type="text" placeholder="Nhập embed url" class="ms-5 text-black/80" style="min-width:500px">
                                        <button @click="serverCreateItem(item.id, episode.dataProduct.id)" class="bg-green-800 border-0 ms-3 text-white/80 hover:text-white uppercase px-3 py-2">Thêm server</button>
                                    </div>
                                    <div class="px-10 pt-10  border-2 border-solid border-black bg-white pb-3">
                                        <table class="w-full text-lg">
                                            <thead>
                                                <tr>
                                                    <th class="border-2 border-solid border-black/50 text-start">Embed URL</th>
                                                    <th class="border-2 border-solid border-black/50">Xóa</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-2 border-solid border-black/50" v-for=" server in item.servers">
                                                    <td class="border-2 border-solid border-black/50 px-2">
                                                        <a class="text-sky-500 hover:text-blue-500" :href="server.embed_url" target="_blank">{{ server.embed_url }}</a>

                                                    </td>
                                                    <td class="border-2 border-solid border-black/50 p-2 text-center">
                                                        <button @click="serverDeleteItem(server.id, episode.dataProduct.id)" class="bg-red-500 text-white px-2  py-2">Xóa</button>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </template>



                    </DataTable>

                </div>
            </template>

            <template #footer>

                <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs" @click="isModalEpisode = false">
                    Đóng
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
            isModalEpisode: false,
            episode: {
                server: {
                    createItem: {
                        embed_url: '',
                        type: 'iframe',
                    }
                },
                dataProduct: {
                    id: '',
                    name: '',
                    full_name: '',
                    url_avatar: '',
                },
                dataTable: [],

                headers: [
                    { text: "Tên Tập", value: "name" },
                    { text: "Hành động", value: "operation" },
                ],
                createItem: {
                    name: '',
                },
                isEditing: false,
                editingItem: {
                    id: 0,
                    name: '',
                },
            },
            checkboxDeleteToTrash: true,
            itemsDelete: [],
            modalDelete: false,
            itemsSelected: [],
            headers: [
                { text: "Thứ tự xuất hiện", value: "ord", sortable: true },
                { text: "Tên dữ liệu", value: "name" },
                { text: "Năm phát hành", value: "nameYear" },
                { text: "Quốc gia", value: "nameNation" },
                { text: "Nổi bật", value: "highlight" },
                { text: "Ản Hiện", value: "status" },
                { text: "Hành động", value: "operation" },
                { text: "Tập phim", value: "episode" },
            ],

        };
    },
    methods: {
        serverDeleteItem(id, id_product) {
            if (confirm("Xác nhận xóa server này ?")) {
                axios.post('/delete-items', {
                    tb: 'servers',
                    dataId: [id],
                    trash: false,
                }).then((response) => {
                    this.loadDataTableEpisode(id_product);
                })
            }

        },
        serverCreateItem(id, id_product) {
            axios.post('server/' + id + '/create', {
                embed_url: this.episode.server.createItem.embed_url,
                type: this.episode.server.createItem.type
            })
                .then((response) => {
                    if (response.data.error) {
                        toast.error(response.data.error, {
                            autoClose: 3000,
                        });

                    } else {
                        this.loadDataTableEpisode(id_product);

                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        episodeDeleteItem(id, id_product) {

            if (confirm("Xác nhận xóa Tập  này ?")) {
                axios.post('/delete-items', {
                    tb: 'episodes',
                    dataId: [id],
                    trash: false,
                }).then((response) => {
                    this.loadDataTableEpisode(id_product);
                })
            };

        },
        episodeUpdateItem(id) {
            axios.post('episode/' + id + '/update/' + this.episode.editingItem.id, {
                name: this.episode.editingItem.name
            })
                .then((response) => {
                    if (response.data.error) {
                        toast.error(response.data.error, {
                            autoClose: 3000,
                        });

                    } else {
                        this.loadDataTableEpisode(id);
                        toast.success("Uploads dữ liệu thành công", {
                            autoClose: 1000,
                        });
                        this.episode.isEditing = false;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        episodeShowEditItem(id, name) {
            this.episode.editingItem.id = id;
            this.episode.editingItem.name = name;
            this.episode.isEditing = true;
        },
        episodeCreateItem(id) {
            axios.post('episode/' + id + '/create', {
                name: this.episode.createItem.name
            })
                .then((response) => {
                    if (response.data.error) {
                        toast.error(response.data.error, {
                            autoClose: 3000,
                        });

                    } else {
                        this.loadDataTableEpisode(id);
                        toast.success("Uploads dữ liệu thành công", {
                            autoClose: 1000,
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        changeNameEpisode(id, value) {
            console.log(value);
        },
        loadDataTableEpisode(id) {
            axios.post('episode/' + id + '/load-data-table')
                .then((response) => {
                    this.episode.dataTable = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showListEpisode(id, url_avatar, full_name, name) {
            this.loadDataTableEpisode(id);
            this.episode.dataProduct.id = id;
            this.episode.dataProduct.url_avatar = url_avatar;
            this.episode.dataProduct.full_name = full_name;
            this.episode.dataProduct.name = name;
            this.isModalEpisode = true;

        },
        closeModalEpisode() {
            this.isModalEpisode = false;
        },
        closeModal() {
            this.modalDelete = false;
        },
        changeORD(id, name, event) {
            if (event.target.value) {


                axios.post('/change-ord', {
                    tb: 'products',
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
                const response = await axios.post('/delete-items', {
                    tb: 'products',
                    dataId: dataDelete,
                    trash: checkboxDeleteToTrash,
                });

                this.loadData();
                this.modalDelete = false;
                toast.success("Xóa dữ liệu thành công", {
                    autoClose: 1500,
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
                    tb: 'products',
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
                    tb: 'products',
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
            axios.post('product-series/load-data-table')
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


        const searchField = ref("name");
        const searchValue = ref();






        return {
            dataPage, checkedStatusItems, checkedHighlightItems, trashCount, loadData, searchField,
            searchValue
        }
    },
    // Các phương thức khác của component
}
</script>
