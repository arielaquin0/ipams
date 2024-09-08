import router from '@/router'
import settings from './settings'
import { getToken, setToken } from '@/utils/auth'
import NProgress from 'nprogress'
NProgress.configure({ showSpinner: false })
import 'nprogress/nprogress.css'
import { useUserStore } from '@/stores/user'

const whiteList = ['/login', '/404'] // no redirect whitelist

router.beforeEach(async (to, from, next) => {
    // start progress bar
    if (settings.isNeedNprogress) NProgress.start()
    // set page title
    document.title = settings.title;

    const hasToken = getToken()
    const userStore = useUserStore();
    if (hasToken) {
        if (to.path === '/login') {
            next({ path: '/' })
        } else {
            try {
                next({ ...to, replace: true })
            } catch (err) {
                await userStore.resetState()
                next(`/login?redirect=${to.path}`)
                if (settings.isNeedNprogress) NProgress.done()
            }
        }
    } else {
        if (whiteList.indexOf(to.path) !== -1) {
            next()
        } else {
            next(`/login?redirect=${to.path}`)
            if (settings.isNeedNprogress) NProgress.done()
        }
    }
})

router.afterEach(() => {
    if (settings.isNeedNprogress) NProgress.done()
})
