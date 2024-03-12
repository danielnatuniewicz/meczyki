document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('addArticle').addEventListener('submit', async function(event) {
        event.preventDefault();
        try{
            const formData = new FormData(this);

            const response = await fetch('/api/article/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    title: formData.get('title'),
                    text: formData.get('text')
                })
            })

            const responseData = await response.json();

            if(response.ok){
                if(responseData.status == 200){
                    document.getElementById('status').innerHTML = '<div class="alert alert-success">' + responseData.message + '</div>';
                }else{
                    document.getElementById('status').innerHTML = '<div class="alert alert-danger">' + responseData.message + '</div>';
                }

                return;
            }

            document.getElementById('status').innerHTML = '<div class="alert alert-danger">' + responseData.message + '</div>';

        }catch(error) {
            document.getElementById('status').innerHTML = '<div class="alert alert-danger">Błąd połączenia z serwerem</div>';
        }
    });
});
