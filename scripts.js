document.addEventListener('DOMContentLoaded', () => {
    const triageForm = document.getElementById('triage-form');
    const patientList = document.getElementById('patient-list');

    triageForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(triageForm);
        const response = await fetch('backend.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            loadPatients();
        }
    });

    async function loadPatients() {
        const response = await fetch('backend.php');
        const patients = await response.json();
        patientList.innerHTML = patients.map(patient => `
            <div class="patient-item">
                <p>Name: ${patient.name}</p>
                <p>Severity: ${patient.severity}</p>
                <p>Added: ${new Date(patient.created_at).toLocaleString()}</p>
            </div>
        `).join('');
    }

    loadPatients();
});