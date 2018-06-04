<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Transaction Table
                    </div>
                    <div class="card-body">
                        <div class="btn-toolbar form-group" role="toolbar">
                            <div class="mx-1 row">
                                <input type="text" class="form-control" v-on:keyup.enter="getList()"
                                       v-model="filter.searchTransactionID" placeholder="Transaction ID" aria-label="Transaction ID" >
                            </div>
                            <div class="mx-1 row">
                                <input type="text" class="form-control" v-on:keyup.enter="getList()"
                                       v-model="filter.searchPlayerID" placeholder="Player ID" aria-label="Player ID" >
                            </div>

                            <button type="button" class="btn btn-success" v-on:click="searchClick()">Search</button>
                        </div>

                        <table class="table table-striped table-bordered table-responsive-sm table-sm" v-bind:class="{'table-loading' : loading}">
                            <preloader :isLodading="loading" />
                            <thead>
                                <tr>
                                    <th class="sorting" v-on:click="sortCol('id')" v-bind:class="[filter.sort == 'id' ? filter.dir : '']">#ID</th>
                                    <th class="sorting" v-on:click="sortCol('amount')" v-bind:class="[filter.sort == 'amount' ? filter.dir : '']">Amount</th>
                                    <th class="sorting" v-on:click="sortCol('type')" v-bind:class="[filter.sort == 'type' ? filter.dir : '']">Type</th>
                                    <th class="sorting" v-on:click="sortCol('currency_id')" v-bind:class="[filter.sort == 'currency_id' ? filter.dir : '']">Status</th>
                                    <th class="sorting" v-on:click="sortCol('created_at')" v-bind:class="[filter.sort == 'created_at' ? filter.dir : '']">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rowData, index in listData">
                                    <td>#{{rowData.id}}</td>
                                    <td>{{rowData.amount}}{{rowData.debitwallet.currency.symbol}}({{rowData.debitwallet.currency.code}})</td>
                                    <td>{{rowData.type}}</td>
                                    <td>{{rowData.status}}</td>
                                    <td>{{rowData.created_at}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="btn-toolbar justify-content-between form-group" role="pagination">
                            <b-form-select class="form-control limit-select"
                                           v-model="filter.limit"
                                           :options="{ '25': '25', '50': '50', '100' : '100' }"
                                           id="type-input">
                            </b-form-select>
                            <b-pagination align="right" :limit="10" :total-rows="filter.limit * filter.lastpage" v-model="filter.page" :per-page="filter.limit">
                            </b-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import tableBase from '../../components/table.vue';
    import TypeAhead from 'vue2-typeahead';
    import Preloader from "../../components/preloader";
    export default {
        extends : tableBase,
        data: function () {
            return {
                apiurl: '/bapi/transaction',
                listData: [],
                filter : {
                    sort : 'created_at',
                    dir: 'desc',
                    page: 1,
                    limit: 25,
                    search: '',
                    searchTransactionID: '',
                    searchPlayerID: '',
                    lastpage: 1,
                    dateFrom: '',
                    dateTo: '',
                },
                loading : true
            }
        },
        methods: {
            searchClick() {
                let app = this;
                app.getList();
            },
        },
        watch : {

        },
        components : {
            Preloader,
            TypeAhead
        }
    }
</script>
<style>
    ul.dropdown-menu-list {
        width: 350px;
    }
</style>