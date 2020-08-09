<template>
    <div>
        <v-dialog persistent v-model="dialog" width="350">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title>
                        <v-btn icon @click="$emit('close')"><v-icon>mdi-close</v-icon></v-btn>
                        <span v-if="estado._id">Editar</span>
                        <span v-else>Adicionar estado</span>
                        <v-btn outlined text @click="salvar">Salvar</v-btn>
                    </v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <v-text-field  label="Sigla" v-model="estado.code"></v-text-field>
                    <v-text-field  label="Nome" v-model="estado.name"></v-text-field>
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
        estado: {
            type: Object,
            default: () => {
                return {code: '', name: ''}
            }
        }
    },
    data: () => ({

    }),
    methods: {

        salvar(){

            if (this.estado._id != null) {
                this.update()
            } else {
                this.create()
            }
 
        },

        create(){

            var self = this
            self.$http.post('/estado', self.estado).then(response => {
                console.log(self.estado)
                self.$emit('reload')
                self.$emit('close')
                alert('Salvo com sucesso: ' + response.data.message)
            }).catch(error => {
                alert('Algo deu errado: ' + error.data.message)
            })
 
        },

        update(){

            var self = this
            self.$http.put(`/estado/${self.estado._id}`, self.estado).then(response => {
                self.$emit('reload')
                self.$emit('close')
                alert('Salvo com sucesso: ' + response.data.message)
            }).catch(error => {
                alert('Algo deu errado: ' + error.data.message)
            })
 
        },
    },
    mounted () {

    }
}
</script>