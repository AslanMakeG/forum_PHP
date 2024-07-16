let innertext = '';
let lastTarget;

function editAnswer(event){
    let answer_id = event.target.dataset.answer;
    let theme_id = event.target.dataset.theme;
    
    if(innertext != ''){
        lastTarget.innerHTML = innertext;
        lastTarget.classList.remove('edit');
    }

    lastTarget = event.target.parentNode.parentNode;

    let answer = event.target.parentNode.parentNode;

    innertext = answer.innerHTML;

    let searchString = new URLSearchParams(window.location.search);

    let page = searchString.get('page');

    answer.innerHTML = `
        <form style="width: 100%;" action="/vendor/edit_answer.php" method="POST">
            <input type="hidden" name="answer" value="${answer_id}">
            <input type="hidden" name="theme" value="${theme_id}">
            <input type="hidden" name="page" value="${page}">
            <textarea class="edit-answer" type="textarea" name="body" placeholder="Введите текст" required>${answer.children[0].textContent}</textarea><br>
            <div>
                <input class="create-theme-form-button" id="save" type="submit" value="Сохранить">
                <button type="button" class="create-theme-form-button" onclick="cancelAnswer(event)">
                    Отмена
                    <input type="hidden" value="${answer_id}">
                </button>
            </div>
        </form>
    `;

    answer.classList.add('edit');
}

function editTheme(event){
    let theme_id = event.target.dataset.theme;

    let answer = event.target.parentNode.parentNode;

    if(innertext != ''){
        lastTarget.innerHTML = innertext;
        lastTarget.classList.remove('edit');
    }

    lastTarget = event.target.parentNode.parentNode;

    innertext = answer.innerHTML;

    let searchString = new URLSearchParams(window.location.search);

    let page = searchString.get('page');

    answer.innerHTML = `
        <form style="width: 100%;" action="/vendor/edit_theme.php" method="POST">
            <input type="hidden" name="theme" value="${theme_id}">
            <textarea class="edit-answer" type="textarea" name="body" placeholder="Введите текст" required>${answer.children[1].textContent}</textarea><br>
            <div>
                <input class="create-theme-form-button" id="save" type="submit" value="Сохранить">
                <button type="button" class="create-theme-form-button" onclick="cancelAnswer(event)">
                    Отмена
                </button>
            </div>
        </form>
    `;

    answer.classList.add('edit');
}

function cancelAnswer(event){
    let answer = event.target.parentNode.parentNode.parentNode;

    answer.innerHTML = innertext;

    innertext = '';
    lastTarget = null;

    answer.classList.remove('edit');
}

function deleteAnswer(event){
    let modal = document.getElementById('modal');
    let answerField = document.getElementById('hiddenModal');
    let modalMessage = document.getElementById('modalMessage');

    answerField.value = event.target.dataset.answer;
    modalMessage.textContent = 'Вы действительно хотите удалить этот ответ?';

    modal.style.display = 'block';
}

function deleteImage(event, table){
    let modal = document.getElementById('modal');
    let modalForm = document.getElementById('modalForm');
    let imageField = document.getElementById('hiddenModal');
    let modalMessage = document.getElementById('modalMessage');

    imageField.value = event.target.dataset.imageid;
    modalMessage.textContent = 'Вы действительно хотите удалить это изображение из своего ответа?';

    if(table == 'theme'){
        modalForm.setAttribute('action', 'vendor/delete_image_theme.php')
    }
    else if (table == 'answer'){
        modalForm.setAttribute('action', 'vendor/delete_image.php')
    }

    modal.style.display = 'block';

    console.log(table);
}

function closeModal(event){
    let modal = document.getElementById('modal');
    let answerField = document.getElementById('hiddenModal');

    answerField.value = null;

    modal.style.display = 'none';
}

function deleteTheme(event){
    let modal = document.getElementById('modal');
    let themeField = document.getElementById('hiddenModal');
    let modalForm = document.getElementById('modalForm');
    let modalMessage = document.getElementById('modalMessage');

    modalMessage.textContent = 'Вы действительно хотите удалить эту тему?';

    themeField.value = event.target.dataset.theme;

    modalForm.setAttribute('action', 'vendor/delete_theme.php')

    modal.style.display = 'block';
}

function showImage(event){
    let modal = document.getElementById('modal2');
    let modalImage = document.getElementById('modalImage');

    modalImage.setAttribute('src', event.target.src);

    modal.style.display = 'flex';
}

function closeImage(event){
    let modal = document.getElementById('modal2');

    modal.style.display = 'none';
}