<template>
    <div>
        <div v-for="(doc, idx) in documents" :key="idx">
            <b-button
                v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                variant="flat-primary"
                class="p-0"
                :href="doc.legal_document_path"
                target="_blank"
            >
                <b-avatar
                    variant="light"
                    class="mb-1"
                    square
                    :text="doc.legal_document_name.split('.').pop()"
                    :src="
                        'http://127.0.0.1:8000/images/icons/' +
                        doc.legal_document_name.split('.').pop() +
                        '.png'
                    "
                    size="lg"
                />
            </b-button>

            <b-button
                v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                variant="outline-dark"
                size="sm"
                :href="doc.legal_document_path"
                target="_blank"
            >
                {{ doc.legal_document_name }}
            </b-button>
        </div>
    </div>
</template>

<script>
import { BButton, BAvatar } from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

export default {
    props: ["documents"],
    components: {
        BButton,
        BAvatar,
    },
    data() {
        return {

        };
    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
