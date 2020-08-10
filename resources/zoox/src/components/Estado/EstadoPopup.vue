<template>
    <div>
        <v-dialog persistent v-model="dialog" width="350">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title>
                        <v-btn icon @click="$emit('close')"><v-icon>mdi-close</v-icon></v-btn>
                        <span v-if="estado._id">Editar</span>
                        <span v-else>Adicionar estado</span>
                        <v-btn outlined text @click="salvar" :disabled="!form_validate">Salvar</v-btn>
                    </v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <v-form ref="form" v-model="form_validate">
                    <v-text-field
                        ref="code"
                        :rules="[rules.required, rules.counter]"
                        label="Sigla" v-model="estado.code"></v-text-field>
                    <v-text-field  
                        ref="name"
                        :rules="[rules.required, rules.counterName]"
                        label="Nome" v-model="estado.name"></v-text-field>
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
        estado: {
            type: Object,
            default: () => {
                return {code: '', name: ''}
            }
        }
    },
    data: () => ({
        form_validate: false,
        rules: {
          required: value => !!value || 'Campo obrigatório.',
          counter: value => value.length >= 2 || 'Min 2 caracteres',
          counterCode: value => value.length >= 2 || 'Min 2 caracteres',
          counterName: value => value.length >= 4 || 'Min 4 caracteres',
        }
    }),

    computed: {
      form () {
        return {
          name: this.estado.name,
          code: this.estado.code,
        }
      },
    },

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
            self.$http.put(`/estado/${self.estado._id}`, self.estado).then(response => {
                self.$emit('reload')
                self.$emit('close')
                alert('Salvo com sucesso: ' + response.data.message)
            }, function(error) {
                alert('Algo deu errado: ' + error.response.data.message)
            })
 
        },
    },
    mounted () {

    }
}
</script>