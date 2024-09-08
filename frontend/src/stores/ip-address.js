import { defineStore } from "pinia";
import { fetch, store, update, showAuditLog } from "@/api/ip-address";

export const useIpAddressStore = defineStore('ip-address', {
    actions: {
        fetchIpAddresses(params) {
            return new Promise((resolve, reject) => {
                fetch(params)
                    .then(res => {
                        resolve(res);
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },
        storeIpAddress(data) {
            return new Promise((resolve, reject) => {
                store(data)
                    .then(res => {
                        resolve(res);
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },
        updateIpAddress(id, data) {
            return new Promise((resolve, reject) => {
                update(id, data)
                    .then(res => {
                        resolve(res);
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        },
        showAuditLog(data) {
            return new Promise((resolve, reject) => {
                showAuditLog(data)
                    .then(res => {
                        resolve(res);
                    })
                    .catch(error => {
                        reject(error)
                    })
            });
        }
    }
});
