import { defineStore } from 'pinia'
import bus from "@/utils/bus";

export const useModalStore = defineStore('modal', {
    state: () => {
        return {
            modalData: {},
        }
    },

    actions: {
        M_modal(data) {
            this.$patch((state) => {
                state.modalData = data
            })
        },

        callModal(payload) {
            return new Promise((resolve) => {
                this.M_modal(payload);
                resolve(null);

                bus.emit('openModal');
            })
        },

        closeModal() {
            return new Promise((resolve) => {
                this.$patch((state) => {
                    state.modalData = {}
                })
                resolve(null);

                bus.emit('closeModal');
            })
        },

        resetModal() {
            this.M_modal({});
        }
    }
})
