<style>
.ck-editor__editable {
    min-height: 200px;
    max-height: 700px;
    overflow-y: scroll;
    /* Đặt chiều cao tối thiểu ở đây */
}

.ck-editor__nested-editable {
    min-height: 50px !important;
}
</style>
<template>
    <div>
        <Loading v-if="isLoading" />

        <!-- <div class="w-full flex items-center justify-end py-3">
            <div class="relative">
                <div class="flex items-center ">
                    <label for="" class="text-xl me-5">Ai tạo khung nội dung tự động </label>
                    <input placeholder="Nhập tiêu đề" style="width: 500px;" type="text" class=" text-black" v-model="chatGPTContent">

                    <button @click="generateContent" class="px-10 py-2 text-xl bg-green-700 text-white  w-80 flex items-center justify-between">
                        <icon :icon="['fa-brands', 'bots']" class="text-black text-4xl" />
                        Tạo Nội Dung
                    </button>
                </div>



            </div>


        </div> -->




        <div>
            <ckeditor v-model="editer_data" :config="editorConfig" :editor="editor" @ready="onReady"></ckeditor>
        </div>

    </div>
</template>

<script>
import DecoupledEditor from '@ckeditor/ckeditor5-build-decoupled-document';
import Loading from '@/Components/Loading.vue';

import { ref, watchEffect } from 'vue';

export default {
    name: 'Editer',
    components: {
        Loading
    },
    data() {
        return {
            editor: DecoupledEditor,

            aiReturn: '',
        };
    },
    props: { data: String },
    methods: {

        onReady(editor) {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );

            // Thêm trình xử lý sự kiện khi người dùng chọn tệp tin để tải lên
            // editor.plugins.get('FileRepository').createUploadAdapter = loader => {

            //     return {
            //         upload() {
            //             return loader.file
            //                 .then(file => {
            //                     const formData = new FormData();
            //                     formData.append('photo', file);


            //                     return axios.post('/ckediter-uploads-file', formData)
            //                         .then(response => {
            //                             // Trả về đối tượng với URL tệp tin đã tải lên
            //                             return { default: response.data.url };
            //                         })
            //                         .catch(error => {
            //                             console.error('Error during file upload', error.response);
            //                             throw error;
            //                         });
            //                 });
            //         },

            //         abort() {
            //             // Thực hiện xử lý khi người dùng hủy tải lên
            //             console.log('Upload aborted');
            //         },
            //     };
            // };
        },
    },
    setup(props) {
        const editer_data = ref('');
        const isLoading = ref(false);
        const chatGPTContent = ref('');
        watchEffect(() => {
            if (props.data) {

                editer_data.value = props.data;
            } else {
                editer_data.value = '';

            }
        });
        const editorConfig = {
            mediaEmbed: {
                previewsInData: true
            },
            alignment: {
                options: ['left', 'center', 'right']
            },

            toolbar: [
                'undo', 'redo',
                '|', 'heading',
                '|', 'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                '|', 'bold', 'italic', 'underline', 'strikethrough',
                '|', 'link', 'blockQuote', 'insertTable',
                '|', 'bulletedList', 'numberedList', 'outdent', 'indent', 'alignment',
                '|', 'ckfinder', 'mediaEmbed', 'Markdown'

            ],
        };

        const generateContent = () => {
            isLoading.value = true;
            axios.post('/generate-content', {
                data: chatGPTContent.value
            })
                .then((response) => {
                    isLoading.value = false;
                    editer_data.value = response.data;

                })
                .catch((error) => {
                    isLoading.value = false;

                    console.error(error);
                });

        };
        return {

            editer_data, editorConfig, generateContent, isLoading, chatGPTContent

        };
    },
};
</script>
<style scoped></style>
