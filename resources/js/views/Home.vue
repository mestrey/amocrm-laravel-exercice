<template>
    <div class="container-fluid" style="margin-top: 2rem">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Есть контакт</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="lead in leads" :key="lead.id">
                    <td>{{ lead.id }}</td>
                    <td>{{ lead.name }}</td>
                    <td>{{ lead.created_at }}</td>
                    <td>?</td>
                    <td>?</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            leads: [],
        };
    },
    created() {
        this.axios.get(this.$api("/leads", "page=1")).then((r) => {
            this.leads = r.data.leads;
            console.log(this.leads);
        });
    },
};
</script>
