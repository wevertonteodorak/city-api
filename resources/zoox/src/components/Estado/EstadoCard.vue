<template>
    <div>
        <estado-popup 
            :estado="estado"
            :dialog="estado_popup_visible" 
            @close="estado_popup_visible=false"
            @reload="$emit('reload')"/>
        <v-card width="100%" class="pa-3">
            <v-row no-gutters class="overline grey--text">
                <v-col cols="1">Sigla</v-col>
                <v-col cols="3">Nome</v-col>
                <v-col cols="2">Criado</v-col>
                <v-col cols="2">Atualizado</v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="1">{{estado.code}}</v-col>
                <v-col cols="3">{{estado.name}}</v-col>
                <v-col cols="2">{{estado.created_at}}</v-col>
                <v-col cols="2">{{estado.updated_at}}</v-col>
                <v-col cols="3" class="text-end">
                    <v-btn icon @click="estado_popup_visible=true"><v-icon>mdi-circle-edit-outline</v-icon></v-btn>
                    <v-btn icon @click="destroy"><v-icon>mdi-delete</v-icon></v-btn>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
import EstadoPopup from './EstadoPopup'
export default {
    name: 'EstadoCard',
    components: {EstadoPopup},
    props: {
        estado: {
            type: Object,
        }
    },
    data: () => ({
        estado_popup_visible: false
    }),

    methods: {
      destroy(){
        var self = this
        self.$http.delete(`/estado/${self.estado._id}`).then(response => {
            alert('Deletada com sucesso: ' + response.data.message)
            self.$emit('reload')
        }).catch(error => {
            alert('Algo deu errado: ' + error.data.message)
        })
      },
      edit(){
        this.estado_popup_visible = true
      },
      edit_commit(data){
        var self = this
        self.$http.put(`/estado/${data._id}`, data).then(response => {
            alert('Altarado com sucesso: ' + response.data.message)
            self.$emit('reload')
        }).catch(error => {
            alert('Algo deu errado: ' + error.data.message)
        })
      },
    }
}
</script>