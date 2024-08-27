const express = require('express');
const app = express();
const port = 3000; // You can use any port you prefer

// Mock data - replace this with your database query or data source
const clientsData = [
  {
    id: 1,
    first_name: 'John',
    middle_name: 'Doe',
    last_name: 'Smith',
    sex: 'Male',
    province: 'Province A',
    city: 'City B',
    barangay: 'Barangay C',
    street: 'Street D',
    religion: 'Religion X',
    date_of_birth: '01/01/1990',
    place_of_birth: 'Place Y',
    admissions: [
      {
        committing_court: 'Court A',
        crim_case_number: '12345',
        offense_committed: 'Offense X',
        date_admitted: '01/01/2022',
        days_in_jail: 30,
        days_in_detention_center: 60,
        distinguishing_marks: [
          {
            tattoo_scars: 'Scar on arm',
            height: '180cm',
            weight: '75kg',
            colour_of_eye: 'Brown',
            skin_colour: 'Light',
          },
        ],
        documents: [
          { submitted: true },
          { submitted: false },
          { submitted: true },
          { submitted: true },
          { submitted: false },
          { submitted: true },
        ],
        general_impression: 'Calm and cooperative',
        action_taken: 'Rehabilitation program initiated',
      },
    ],
  },
  // Add more client objects as needed
];

// API endpoint to fetch client data by ID
app.get('/api/clients-data/:id', (req, res) => {
  const clientId = parseInt(req.params.id);
  const client = clientsData.find(client => client.id === clientId);

  if (client) {
    res.json([client]); // Return the client data as an array (assuming `clients` in Vue.js expects an array)
  } else {
    res.status(404).json({ error: 'Client not found' });
  }
});

// Serve static files from the 'public' directory
app.use(express.static('public'));

// Start the server
app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
