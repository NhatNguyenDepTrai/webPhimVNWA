<template>
    <div class="flex items-center w-full  mb-3 ">
        <div class="relative w-full mr-3 formkit-field">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <icon :icon="['fas', 'image']" />
            </div>
            <input id="inputImage" v-model="url_image" @input="notifyParent" class="formkit-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email_address" aria-label="Email Address" placeholder="Đường dẫn ảnh" required="" type="email">
        </div>
        <button @click="openCKFinder" style="min-width: 120px;" class="px-5 py-3 w-auto text-sm font-medium text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <icon :icon="['fas', 'circle-down']" /> Chọn ảnh
        </button>
    </div>
    <div class="border rounded p-4">
        <img :src="appFileUrl+'/'+url_image" width="100%" height="auto" class="w-full h-auto" alt="">
    </div>
</template>

<script>
import { ref, watchEffect } from 'vue';

export default {
  data () {
    return {
        appFileUrl:import.meta.env.VITE_API_FILE
    }
  },
    methods: {

    },
    emits: ['child-changed'],
    props: { data: String },
    setup(props, { emit }) {
        const url_image = ref('');

        watchEffect(() => {
            url_image.value = props.data;

        });

        function openCKFinder() {
            CKFinder.popup({
                chooseFiles: true,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        const file = evt.data.files.first();
                        const imageUrl = file.getUrl();
                        url_image.value = imageUrl;
                        emit('child-changed', url_image.value);

                    });
                }
            });
        }
        return {
            url_image,
            openCKFinder,
        };
    },

}
</script>
