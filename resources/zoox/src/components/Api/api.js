import axios from 'axios'

//axios.defaults.baseURL = window.location.protocol+"//"+window.location.hostname+"/api"
axios.defaults.baseURL = window.location.protocol+"//192.168.0.10:8000/api"
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Accept'] = 'application/json'

export function api_get(uri) {
    axios.get(uri).then(response => {
        return response.data
    }).catch(error => {
        alert('Algo deu errado: ' + error.data.message)
        return []
    })
}

export async function api_post(uri, data) {
    axios.post(uri, data).then(response => {
        alert('Operação relizada com sucesso. '+response.data.message)
    }).catch(error => {
        alert('Algo deu errado: '+error.data.message)
    }) 
}

export async function api_put(uri, data) {
    axios.put(uri, data).then(response => {
        alert('Operação relizada com sucesso. '+response.data.message)
    }).catch(error => {
        alert('Algo deu errado: '+error.data.message)
    }) 
}

export async function api_delete(uri) {
    axios.delete(uri).then(response => {
        alert('Operação relizada com sucesso. '+response.data.message)
    }).catch(error => {
        alert('Algo deu errado: '+error.data.message)
    }) 
}