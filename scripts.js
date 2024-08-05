document.addEventListener('DOMContentLoaded', () => {
    const triageForm = document.getElementById('triage-form');
    const patientList = document.getElementById('patient-list');

    triageForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(triageForm);

        try {
            const response = await fetch('addPatient.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();

            if (result.success) {
                loadPatients(); 
            } else {
                console.error('Error:', result.message);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    });

    async function loadPatients() {
        try {
            const response = await fetch('getPatients.php');

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const patients = await response.json();

            patientList.innerHTML = patients.map(patient => `
                <div class="patient-item">
                    <p>Name: ${patient.name}</p>
                    <p>Severity: ${patient.severity}</p>
                    <p>Added: ${new Date(patient.created_at).toLocaleString()}</p>
                </div>
            `).join('');
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    loadPatients();
});