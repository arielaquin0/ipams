import request from '@/utils/axiosReq'

export function fetch(params) {
    return request({
        url: '/ip-addresses',
        method: 'get',
        params,
    })
}

export function store(data) {
    return request({
        url: '/ip-addresses',
        method: 'post',
        data,
    });
}

export function update(id, data) {
    return request({
        url: `/ip-addresses/${id}`,
        method: 'put',
        data,
    });
}

export function showAuditLog(id) {
    return request({
        url: `/ip-addresses/${id}/audit-log`,
        method: 'get',
    });
}
