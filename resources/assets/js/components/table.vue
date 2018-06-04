<template>
</template>

<script>
    import preloader from './preloader.vue';
    export default {
        data: function () {
            return {
                loading : false,
                apiurl: '',
                listData: [],
                filter : {
                    sort : 'name',
                    dir: 'asc',
                    page: 1,
                    limit: 10,
                    search: '',
                    lastpage: 1,
                    showdel : false
                }
            }
        },
        mounted() {
            var app = this;
            app.getList();
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete(app.apiurl + '/' + id)
                        .then(function (resp) {
                            app.getList();
                        })
                        .catch(function (resp) {
                            alert("Could not delete row");
                        });
                }
            },
            restoreEntry(id) {
                if (confirm("Do you really want to restore it?")) {
                    var app = this;
                    axios.patch(app.apiurl + '/' + id + '/restore')
                        .then(function (resp) {
                            app.getList();
                        })
                        .catch(function (resp) {
                            alert("Could not restore row");
                        });
                }
            },
            sortCol(colName) {
                var app = this;
                if (colName == app.filter.sort) {
                    app.filter.dir = app.filter.dir == 'desc' ? 'asc' : 'desc';
                } else {
                    app.filter.sort = colName;
                    app.filter.dir = 'desc';
                }
                app.getList();
            },
            page(pageNum) {
                var app = this;
                app.filter.page = pageNum;
                app.getList();
            },
            showDeleted() {
                var app = this;
                app.filter.showdel = !app.filter.showdel;
                app.getList();
            },
            getList() {
                var app = this;
                app.loading = true;
                axios.get(app.apiurl + '?' + jQuery.param(app.filter))
                    .then(function (resp) {
                        app.loading = false;
                        app.listData = resp.data.data;
                        app.filter.lastpage = resp.data.meta.last_page;
                    })
                    .catch(function (resp) {
                        alert("Could not load page");
                    });
            }
        },
        watch: {
            'filter.limit': function() {
                var app = this;
                app.filter.limit = parseInt(app.filter.limit);
                app.getList();
            },
            'filter.page': function() {
                var app = this;
                app.getList();
            },

        },
        components : {
            preloader
        }
    }
</script>