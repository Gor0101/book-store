async function deleteUser(btn){
    let target = btn.dataset.target
    let userCard = document.querySelector('#userCard' + target)
    let response = await fetch(`/admin/delete/${target}`)
    let data = await response.json()
    if(data['success'] === 1) {
        userCard.remove()
    }
}
