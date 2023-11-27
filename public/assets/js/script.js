function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("openByDefault")?.click();

document.addEventListener('DOMContentLoaded', function () {
    const subjectSelect = document.getElementById("subject_id");
    const classSelect = document.getElementById("class_id");

    subjectSelect?.addEventListener("change", function () {
        const selectedSubjectId = subjectSelect.value;
        const subjectIdNumber = parseInt(selectedSubjectId);

        while (classSelect.firstChild) {
            classSelect.removeChild(classSelect.firstChild);
        }

        if (Number.isNaN(subjectIdNumber)) {
            return;
        }

        // Send the request to get-classes-for-subject.php
        fetch('index.php?api=get-classes-for-subject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify({ subject_id: subjectIdNumber })
        })
            .then(response => response.json())
            .then(data => {
                data.forEach(classData => {
                    const option = document.createElement('option');
                    option.value = classData.id;
                    option.textContent = classData.class;
                    classSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    const programTimeStart = document.getElementById("program_time_start");
    const programTimeEnd = document.getElementById("program_time_end");
    const hour = 40;

    programTimeStart?.addEventListener("change", function () {
        const startTime = programTimeStart.value;
        const startDate = new Date(`2023-07-20T${startTime}:00`);
        startDate.setMinutes(startDate.getMinutes() + hour);
        const endTime = startDate.toTimeString().slice(0, 5);
        programTimeEnd.value = endTime;
    });

    programTimeEnd?.addEventListener("change", function () {
        const endTime = programTimeEnd.value;
        const endDate = new Date(`2023-07-20T${endTime}:00`);
        endDate.setMinutes(endDate.getMinutes() - hour);
        const startTime = endDate.toTimeString().slice(0, 5);
        programTimeStart.value = startTime;
    });

    const gradeTermSelect = document.getElementById("grade_term");
    const gradeTypeLabel = document.getElementById("grade_type_label");
    const gradeTypeSelect = document.getElementById("grade_type");

    gradeTermSelect?.addEventListener("change", function () {
        if (gradeTermSelect.value === "1" || gradeTermSelect.value === "2") {
            gradeTypeLabel.style.display = "block";
            gradeTypeSelect.style.display = "block";
            gradeTypeSelect.setAttribute("required", "required");
        } else {
            gradeTypeLabel.style.display = "none";
            gradeTypeSelect.style.display = "none";
            gradeTypeSelect.removeAttribute("required");
        }
    });
});

const password = document.getElementById('password');
const passwordConfirm = document.getElementById('password-confirm');

const toggler = document.getElementById('toggler');
const togglerConfirm = document.getElementById('toggler-confirm');

showHidePassword = (password, toggler) => {
    if (!password || !toggler) {
        return;
    }

    if (password.type == 'password') {
        password.setAttribute('type', 'text');
        toggler.classList.add('fa-eye-slash');
    } else {
        toggler.classList.remove('fa-eye-slash');
        password.setAttribute('type', 'password');
    }
};

toggler.addEventListener('click', () => showHidePassword(password, toggler));
togglerConfirm.addEventListener('click', () => showHidePassword(passwordConfirm, togglerConfirm));
