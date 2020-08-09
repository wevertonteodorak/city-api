<template>
    <div>
        <v-dialog persistent v-model="dialog" width="350">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title>
                        <v-btn icon @click="$emit('close')"><v-icon>mdi-close</v-icon></v-btn>
                        <span v-if="cidade._id">Editar</span>
                        <span v-else>Adicionar cidade</span>
                        <v-btn outlined text @click="salvar">Salvar</v-btn>
                    </v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <v-text-field  label="Sigla" v-model="cidade.code"></v-text-field>
                    <v-text-field  label="Nome" v-model="cidade.name"></v-text-field>
                    <v-select 
                        v-model="cidade.estado_id"
                        item-text="name"
                        item-value="_id"
                        :items="estados" 
                        label="Estado" />
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    props: {
        dialog: {
            type: Boolean,
            default: false
        },
        cidade: {
            type: Object,
            default: () => {
                return {code: '', name: '', estado_id: ''}
            }
        }
    },
    data: () => ({
        estados: []
    }),
    methods: {

        salvar(){

            if (this.cidade._id != null) {
                this.update()
            } else {
                this.create()
            }
 
        },

        create(){

            var self = this
            self.$http.post('/cidade', self.cidade).then(response => {
                console.log(self.cidade)
                self.$emit('reload')
                self.$emit('close')
                alert('Salvo com sucesso: ' + response.data.message)
            }).catch(error => {
                alert('Algo deu errado: ' + error.data.message)
            })
 
        },

        update(){

            var self = this
            self.$http.put(`/cidade/${self.cidade._id}`, self.cidade).then(response => {
                self.$emit('reload')
                self.$emit('close')
                alert('Salvo com sucesso: ' + response.data.message)
            }).catch(error => {
                alert('Algo deu errado: ' + error.data.message)
            })
 
        },
        
        getEstadosList(){

            var self = this
            self.$http.get('/estado').then(response => {
                self.estados = response.data

            }).catch(error => {
                alert('Algo deu errado: ' + error.data.message)
            })
 
        }
    },
    mounted () {
        this.getEstadosList()
    }
}
</script>