<template lang="">
    <div>
        <Multiselect v-model="dataSelectedOptions" mode="tags" :close-on-select="false" :searchable="true" :create-option="true" :options="dataOptions" />

    </div>
</template>
<script>
import { ref } from 'vue';
import Multiselect from '@vueform/multiselect';

export default {
    components: {
        Multiselect,
    },
    props: {
        selected: Array,
        options: {},
    },
    setup(props) {
        const dataSelectedOptions = ref([]);
        const dataOptions = ref({});

        if (props.selected) {
            dataSelectedOptions.value = props.selected;
        }

        if (props.options) {
            dataOptions.value = props.options;
        }
        return {
            dataSelectedOptions,
            dataOptions,
        };
    }

}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>

