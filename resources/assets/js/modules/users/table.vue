<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>BO Users Table
                    </div>
                    <div class="card-body">
                        <div class="btn-toolbar justify-content-between form-group" role="toolbar">
                            <router-link :to="{name: 'UsersCreate'}" class="btn btn-success">Create new user</router-link>
                            <div class="filters-group">
                                <div class="input-group mx-2">
                                    <strong>Show Deleted&nbsp;</strong>
                                    <label class="switch switch-default switch-pill switch-success">
                                        <input type="checkbox" class="switch-input" v-model="filter.showdeleted" v-on:click="showDeleted()">
                                        <span class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" id="btnGroupSearch"><i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control" v-model="filter.search" v-on:keyup="getList()" placeholder="Search" aria-label="Search" aria-describedby="btnGroupSearch">
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-responsive-sm table-sm" v-bind:class="{'table-loading' : loading}">
                            <preloader :isLodading="loading" />
                            <thead>
                            <tr>
                                <th class="sorting" v-on:click="sortCol('name')" v-bind:class="[filter.sort == 'name' ? filter.dir : '']">Username</th>
                                <th class="sorting" v-on:click="sortCol('email')" v-bind:class="[filter.sort == 'email' ? filter.dir : '']">Email</th>
                                <th class="sorting" v-on:click="sortCol('created_at')" v-bind:class="[filter.sort == 'created_at' ? filter.dir : '']">Date registered</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rowData, index in listData">
                                    <td><span v-if="rowData.deleted_at != null" class="badge badge-secondary">Deleted</span> {{rowData.name}}</td>
                                    <td>{{rowData.email}}</td>
                                    <td>{{rowData.created_at}}</td>
                                    <td class="text-center" v-if="rowData.deleted_at == null">
                                        <router-link :to="{name: 'UsersEdit', params: {id: rowData.id}}" class="btn btn-outline-warning btn-sm">
                                            Edit
                                        </router-link>
                                        <a v-if="rowData.id != 1" href="#"
                                           class="btn btn-outline-danger btn-sm"
                                           v-on:click="deleteEntry(rowData.id, index)">
                                            Delete
                                        </a>
                                    </td>
                                    <td class="text-center" v-if="rowData.deleted_at != null">
                                        <a href="#"
                                           class="btn btn-outline-warning btn-sm"
                                           v-on:click="restoreEntry(rowData.id)">
                                            Restore
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="btn-toolbar justify-content-between form-group" role="pagination">
                            <b-form-select class="form-control limit-select"
                                           v-model="filter.limit"
                                           :options="{ '10': '10', '25': '25', '50' : '50' }"
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
    export default {
        extends : tableBase,
        data: function () {
            return {
                apiurl: '/bapi/user',
                listData: [],
                filter : {
                    sort : 'name',
                    dir: 'asc',
                    page: 1,
                    limit: 10,
                    search: '',
                    lastpage: 1,
                    showdel: false
                }
            }
        },

    }
</script>