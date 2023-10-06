export async function sendRequest(url) {
    const response = await fetch(url);
    if (!response.ok) {
        console.log(await response.text());
        throw new Error('Something went wrong');
    }
    return await response.json();
}

const switchs = document.querySelectorAll('.cat-visibility-switch');
switchs.forEach(switchElement => {
    switchElement.addEventListener('change', () => {
        const id = switchElement.dataset.id;
        const badge = document.getElementById(`badge-${id}`);
        sendRequest(`/admin/categories/${id}/visibility`).then(r => {
            if (r.status === 'success') {
                badge.classList.toggle('bg-success');
                badge.classList.toggle('bg-danger');
                badge.innerText = r.visibility ? "Yes" : "No";
            }
        });
    });
});
