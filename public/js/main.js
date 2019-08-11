function Preview() {
    let name = $('input[name="name"]').val();
    let email = $('input[name="email"]').val();
    let task = $('input[name="task"]').val();

    $('.modal-body #name').text(name);
    $('.modal-body #email').text(email);
    $('.modal-body #task').text(task);
}