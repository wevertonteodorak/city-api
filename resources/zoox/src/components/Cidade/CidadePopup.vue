<template>
    <div>
        <v-dialog persistent v-model="dialog" width="350">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title>
                        <v-btn icon @click="$emit('close')"><v-icon>mdi-close</v-icon></v-btn>
                        <span v-if="cidade._id">Editar</span>
                        <span v-else>Adicionar cidade</span>
                        <v-btn outlined text @click="salvar" :disabled="!form_validate">Salvar</v-btn>
                    </v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <v-form ref="form" v-model="form_validate">
                    <v-text-field  
                        :rules="[rules.required, rules.counter]"
                        label="Sigla" v-model="cidade.code"></v-text-field>
                    <v-text-field  
                        :rules="[rules.required, rules.counterName]"
                        label="Nome" v-model="cidade.name"></v-text-field>
                    <v-select 
                        v-model="cidade.estado_id"
                        :rules="[rules.required]"
                        item-text="name"
                        item-value="_id"
                        :items="estados" 
                        label="Estado" />
                    </v-form>
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
        estados: [],

        form_validate: false,
        rules: {
          required: value => !!value || 'Campo obrigatório.',
          counter: value => value.length >= 2 || 'Min 2 caracteres',
          counterCode: value => value.length >= 2 || 'Min 2 caracteres',
          counterName: value => value.length >= 4 || 'Min 4 caracteres',
        }
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
            }, function(error) {
                console.log(error)
                alert('Algo deu errado: ' + error.response.data.message)
            })
 
        },

        update(){

            var self = this
            self.$http.put(`/cidade/${self.cidade._id}`, self.cidade).then(response => {
                self.$emit('reload')
                self.$emit('close')
                alert('Salvo com sucesso: ' + response.data.message)
            }, function(error) {
                console.log(error)
                alert('Algo deu errado: ' + error.response.data.message)
            })
 
        },
        
        getEstadosList(){

            var self = this
            self.$http.get('/estado').then(response => {
                self.estados = response.data

            }, function(error) {
                console.log(error)
                alert('Algo deu errado: ' + error.response.data.message)
            })
 
        }
    },
    mounted () {
        this.getEstadosList()
    }
}
</script>