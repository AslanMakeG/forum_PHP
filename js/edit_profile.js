let profilehtml = '';

function editProfile(event){
    let profile =  document.getElementById('profile-body');
    let profile_name =  document.getElementById('profile-name');
    let profile_about =  document.getElementById('profile-about');
    let profile_avatar =  document.getElementById('user-avatar');
    profilehtml = profile.innerHTML;

    document.getElementById('profileButtons').style.display = 'flex';
    document.getElementById('editButton').style.display = 'none';

    let name = profile_name.children[1].textContent;
    let about = profile_about.children[1].textContent == 'не заполнено' ? '' : profile_about.children[1].textContent;
    let avatar_src = profile_avatar.children[0].src;

    profile_name.innerHTML = `
        <p class="profile-p">ФИО: </p>
        <input style="width: 100%; height: 50%; margin-left: 3px;" type="text" name="name" value="${name}" maxlength="100" required>
    `;

    profile_about.innerHTML = `
        <p class="profile-p">Обо мне: </p>
        <input style="width: 100%; height: 50%; margin-left: 3px;" type="text" name="about" value="${about}" maxlength="150">
    `;

    profile_avatar.innerHTML = `
        <div class="user-avatar-border">
            <label for="avatar" class="change-avatar">
                <div class="user-avatar-shadow"></div>
                <p class="change-avatar-p">Изменить аватар</p>
                <img id="avatar-change-image" width="200" height="200" src="${avatar_src}">
            </label>
            <input style="display: none;" id="avatar" type="file" name="avatar" accept=".jpg, .png, .jpeg|image/*">
        </div>
        <button class="delete-image-button" type="button" onclick="showModal(event)"></button>
    `;
    
    profile_avatar.style.width = '225px';

    profile_avatar.classList.remove('user-avatar-border2');

    document.getElementById('avatar').addEventListener('change', function(e) {
        if (e.target.files[0]) {
            let avatar_tmp = URL.createObjectURL(e.target.files[0]);
            console.log(document.getElementById('avatar').value);
            document.getElementById('avatar-change-image').setAttribute('src', avatar_tmp)
        }
    });
}

function cancelEdit(event){
    let profile =  document.getElementById('profile-body');
    profile.innerHTML = profilehtml;
}

function showModal(event){
    let modal = document.getElementById('modal');

    modal.style.display = 'flex';
}

function deleteAvatar(event){
    document.getElementById('avatar-change-image').setAttribute('src', 'img/noavatar.png');

    document.getElementById('avatar').value = '';

    console.log(document.getElementById('avatar').value);

    let modal = document.getElementById('modal');

    modal.style.display = 'none';
}

function closeModal(event){
    let modal = document.getElementById('modal');

    modal.style.display = 'none';
}