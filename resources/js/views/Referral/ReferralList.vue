<template>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">

            <h3 class="card-title align-items-start flex-column">
                <span class="card-label  fs-3 mb-1">Manage Referral Table</span>
                <span class="text-muted mt-1 fw-bold fs-7">Total Records : {{ dataList.meta && dataList.meta.total }}</span>
            </h3>

            <div class="d-flex align-items-center">
                <div class="position-relative w-md-400px me-md-2">
                    <Input @input="filterMethod()" clearable @on-clear="filterMethod()" v-model="params.search" type="text"
                        size="large" class="custom_inp" prefix="ios-search"
                        :placeholder="`Search by referrer name, email`" />
                </div>
            </div>

        </div>

        <div class="card-body py-3">

            <div class="table-responsive">
                <Transition>
                    <table v-if="!$store.state.dataLoading" class="table table-striped align-middle gs-0 gy-4">

                        <thead>
                            <tr class="fw-bolder text-white bg-primary">
                                <th class="min-w-100px">SL No.</th>
                                <th class="min-w-200px">Referrer name</th>
                                <th class="min-w-200px">Email Referred</th>
                                <th class="min-w-200px">Date</th>
                                <th class="min-w-100px">Registered</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(referral, index) in dataList.data" :key="(referral.id)">

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-dark _disable_link text-hover-primary mb-1 fs-6">
                                                {{ (dataList.from ? dataList.from : 1) + index }}</a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-dark _disable_link text-hover-primary mb-1 fs-6">
                                                {{ referral.referrer }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-dark _disable_link text-hover-primary mb-1 fs-6">
                                                {{ referral.email }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-dark _disable_link text-hover-primary mb-1 fs-6">
                                                {{ referral.created_at }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-dark _disable_link text-hover-primary mb-1 fs-6">
                                                <span v-if="referral.is_registered" class="badge badge-success">Yes</span>
                                                <span v-else class="badge badge-danger">No</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </Transition>
                <div v-if="!(dataList.meta && dataList.meta.total)" class="no_data">
                    <h2>No Data Available</h2>
                </div>
            </div>
        </div>

    </div>

    <Page v-if="dataList.meta && dataList.meta.total" @on-page-size-change="e => (params.pageSize = e, getReferral())"
        v-model="params.page" @on-change="getReferral" :total="dataList.meta.total" show-sizer style="text-align:center;" />
</template>

<script>

export default {
    name: 'ReferralList',
    components: {},
    data() {
        return {
            params: {
                search: null,
                page: 1,
                pageSize: 10,
            },
        }
    },
    methods: {
        async getReferral() {
            this.$store.state.dataLoading = true;
            const res = await this.callApi('get', '/web/referral/referral-list', null, this.params);
            if (res.status === 200) {
                this.$store.commit('setDataList', res.data);
            }
            setTimeout(() => {
                this.$store.state.dataLoading = false;
            }, 200);
        },

        filterMethod(e = null) {
            this.params.page = 1;
            this.getReferral();
        }
    },
    created() {
        // this.setCss('100%')
        this.getReferral();
    }
}
</script>

