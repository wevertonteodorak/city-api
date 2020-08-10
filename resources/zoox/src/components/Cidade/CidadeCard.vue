<template>
    <div>
        <v-card width="100%" class="pa-3">
            <v-row no-gutters class="overline grey--text">
                <v-col cols="1">Sigla</v-col>
                <v-col cols="2">Nome</v-col>
                <v-col cols="2">Estado</v-col>
                <v-col cols="2">Criado em</v-col>
                <v-col cols="2">Atualizado em</v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="1">{{cidade.code}}</v-col>
                <v-col cols="2">{{cidade.name}}</v-col>
                <v-col cols="2">{{cidade.estado.name}}</v-col>
                <v-col cols="2">{{cidade.created_at}}</v-col>
                <v-col cols="2">{{cidade.updated_at}}</v-col>
                <v-col cols="2" class="text-end">
                    <v-btn icon @click="edit"><v-icon>mdi-circle-edit-outline</v-icon></v-btn>
                    <v-btn icon @click="destroy"><v-icon>mdi-delete</v-icon></v-btn>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
//import CidadePopup from './CidadePopup'
export default {
    name: 'CidadeCard',
    components: {},
    props: {
        cidade: {
            type: Object,
        }
    },
    data: () => ({
        cidade_popup_visible: false
    }),

    methods: {
      destroy(){
        var self = this
        self.$http.delete(`/cidade/${self.cidade._id}`).then(response => {
            alert('Deletada com sucesso: ' + response.data.message)
            self.$emit('reload')
        }, function(error) {
                console.log(error)
                alert('Algo deu errado: ' + error.response.data.message)
        })
      },
      edit(){
        var self = this
        this.$root.$emit('edit-cidade', self.cidade)
      },
      edit_commit(data){
        var self = this
        self.$http.put(`/cidade/${data._id}`, data).then(response => {
            alert('Altarado com sucesso: ' + response.data.message)
            self.$emit('reload')
        }, function(error) {
                console.log(error)
                alert('Algo deu errado: ' + error.response.data.message)
            })
      },
    }
}
</script>