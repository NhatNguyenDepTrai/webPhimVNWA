<template>
    <div>
        <div class="flex items-center w-full  mb-3">
            <button @click="openCKFinder" style="min-width: 120px;" class="px-5 py-3 w-auto text-sm font-medium text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <icon :icon="['fas', 'circle-down']" /> Chọn ảnh
            </button>
        </div>
        <div class="border rounded p-4 ">
            <draggable v-model="list_image" :item-key="customKeyFunction" tag="ul" class="grid grid-cols-12 ">
                <template #item="item">
                    <li class="col-span-6 p-1 ButtonMutipleImage_item border">
                        <span class="absolute z-10 bg-white  w-5 text-center text-xs bottom-0 border-solid border-purple-700 border-2">{{ item.index }}</span>
                        <img :src="item.element" width="100%" height="auto" class="w-full h-auto" alt="" />
                        <div class="delete">
                            <button @click="deleteItem(item.index)" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <icon :icon="['fas', 'x']" />
                            </button>
                        </div>
                    </li>
                </template>
            </draggable>

        </div>
    </div>
</template>
<style>
.ButtonMutipleImage_item {
    width: 100%;
    height: 100%;
    position: relative;
    cursor: move;
}

.ButtonMutipleImage_item:active {
    border: solid 1px rebeccapurple;
}

.ButtonMutipleImage_item .delete {
    position: absolute;
    top: -2px;
    left: -2px;
    display: none;
    z-index: 999;
}

.ButtonMutipleImage_item:hover .delete {
    display: block;
}

.ButtonMutipleImage_item .delete button {
    width: 10px;
    height: 10px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;

}
</style>
<script>

import { ref, watchEffect, toRefs } from 'vue';
import draggable from 'vuedraggable';
export default {
    components: {
        draggable
    },
    props: {
        data: {
            type: Array,
            default: () => [],
        }, // Định nghĩa prop để nhận dữ liệu từ thành phần cha
    },
    methods: {
        customKeyFunction(item) {
            // Trả về một giá trị duy nhất để xác định meal
            return item.someUniqueIdentifier;
        },
        deleteItem(index) {
            this.list_image.splice(index, 1);
        }
    },
    setup(props) {

        const list_image = ref(props.data);
        function openCKFinder() {
            CKFinder.popup({
                chooseFiles: true,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        const files = Array.from(evt.data.files.models);
                        files.forEach((file) => {
                            list_image.value.push(file.attributes.url);
                        });
                    });
                },
            });
        }
        return {
            list_image,
            openCKFinder,
        };
    },
};
</script>
