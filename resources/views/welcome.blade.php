@extends('layouts.app')

@section('title', 'Home')

@section('content')
<link href="{{ asset('css/landing.css') }}" rel="stylesheet">



<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm "style="background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);">
    <div class="container" >
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

        
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#" class="nav-link active">Home</a></li>
                <li class="nav-item"><a href="#welcome" class="nav-link">About Us</a></li>
                
                <!-- Patient Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="patientServicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Patient Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="patientServicesDropdown">
                        <li><a class="dropdown-item" href="{{ route('cards.services') }}">Available Services</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Patient Portal</a></li>
                        <li><a class="dropdown-item" href="{{ route('cards.hmo') }}">HMO and Corporate Partners</a></li>
                    
                    
                    </ul>
                </li>

                 <!-- Doctor Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="patientServicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Doctors
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="patientServicesDropdown">
                        <li><a class="dropdown-item" href="{{ route('cards.doctors') }}">Find a Doctor</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Doctor Portal</a></li>
                    </ul>
                </li>

                 <!-- Appointment Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="patientServicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Appointment
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="patientServicesDropdown">
                        <li><a class="dropdown-item" href="#">Submit an Appointment</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Front Desk Portal</a></li>
                    </ul>
                </li>

                <!-- Prescription Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="patientServicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pharmacy
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="patientServicesDropdown">
                        <li><a class="dropdown-item" href="{{ route('medications.index') }}">Pharmaceuticals and Medications</a></li>
                        <li><a class="dropdown-item" href="#">Buy a Prescription</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Hero Section -->
<section class="hero">
    <div class="hero-content text-center text-light">
        <h5 class="mb-2">MATINA DAVAO CITY | GAISANO GRAND MALL BAJADA | SM CITY DAVAO</h5>
        <h1 class="mb-3">Jackson Hospital</h1>
        <p class="mb-4">
            Our comprehensive range of services including check-up, laboratory testing, imaging, and diagnostics<br>
            are designed to provide you with accurate and reliable healthcare solutions for optimal health and wellness.
        </p>
        <div>
            <!-- CARE CENTERS button triggers modal -->
            <button type="button" class="btn btn-green me-3 px-4 py-2" data-bs-toggle="modal" data-bs-target="#careCentersModal">
                CARE CENTERS
            </button>
            <!-- CONTACT US button -->
            <a href="#" class="btn btn-yellow px-4 py-2" data-bs-toggle="modal" data-bs-target="#contactUsModal">
                CONTACT US
            </a>
        </div>
    </div>
</section>

<!-- ✅ Care Centers Modal -->
<div class="modal fade" id="careCentersModal" tabindex="-1" aria-labelledby="careCentersModalLabel" aria-hidden="true" style="color: green;">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content" style="background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);">
      <div class="modal-header bg-green text-light">
        <h5 class="modal-title" id="careCentersModalLabel">Our Care Centers</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row g-3">

            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('images\carecenter.jpeg') }}" class="card-img-top" alt="Gaisano Grand Mall Bajada">
                <div class="card-body">
                     <p class="card-text">Jackson Care Center</p>
                  <h6 class="card-title" style="text-align: left;"><strong>Location:</strong>Unit 45, Bajada, Davao City</h6>
                  <h6 style="text-align: center; font-style: italic;">
             Our Care Centers are committed to providing high-quality, compassionate healthcare services for all patients. Each center offers a comprehensive range of services including general check-ups, laboratory testing, imaging, diagnostics, and personalized wellness programs. Our goal is to ensure accurate, reliable, and patient-centered care in a safe and supportive environment for optimal health and well-being.

                  </h6>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('images\seniorcenter.jpg') }}" class="card-img-top" alt="Gaisano Grand Mall Bajada">
                <div class="card-body">
                     <p class="card-text">Senior Care Center</p>
                  <h6 class="card-title" style="text-align: left;"><strong>Location:</strong>Unit 45, Bajada, Davao City</h6>
                  <h6 style="text-align: center; font-style: italic;">
                    Our Senior Care Center provides compassionate, comprehensive healthcare services tailored to the needs of older adults. We offer routine check-ups, chronic disease management, physical therapy, wellness programs, and personalized care plans to ensure seniors maintain their health, independence, and quality of life in a safe and supportive environment.
                  </h6>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('images\bloodcenter.jpg') }}" class="card-img-top" alt="Gaisano Grand Mall Bajada">
                <div class="card-body">
                     <p class="card-text">Blood Center</p>
                  <h6 class="card-title" style="text-align: left;"><strong>Location:</strong>Unit 46, Sasa, Davao City</h6>
                  <h6 style="text-align: center; font-style: italic;">
                    Our Blood Center is dedicated to ensuring a safe and reliable blood supply for patients in need. We provide blood collection, testing, storage, and distribution services, adhering to strict safety standards. Our team works to support hospitals and medical facilities with timely and quality blood products, contributing to life-saving treatments and emergency care.

                  </h6>
                </div>
              </div>
            </div>

           <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('images\rehab.jpg') }}" class="card-img-top" alt="Gaisano Grand Mall Bajada">
                <div class="card-body">
                     <p class="card-text">Rehabilitation Center</p>
                  <h6 class="card-title" style="text-align: left;"><strong>Location:</strong>Purok 2, Matina Crossing, Davao City</h6>
                  <h6 style="text-align: center; font-style: italic;">
                Our Rehabilitation Center offers specialized programs to help patients recover and regain independence after illness, injury, or surgery. We provide physical therapy, occupational therapy, speech therapy, and personalized rehabilitation plans, focusing on improving mobility, strength, and overall quality of life in a supportive and professional environment.
                  </h6>
                </div>
              </div>
            </div>

           <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('images\thera.jpg') }}" class="card-img-top" alt="Gaisano Grand Mall Bajada">
                <div class="card-body">
                     <p class="card-text">Therapy Center</p>
                  <h6 class="card-title" style="text-align: left;"><strong>Location:</strong>Bajada, Davao City</h6>
                  <h6 style="text-align: center; font-style: italic;">
                    Our Therapy Center offers a range of therapeutic services, including physical therapy, occupational therapy, and speech therapy, designed to help patients recover, strengthen, and improve their daily functioning. Our team of skilled therapists creates personalized care plans to support rehabilitation, enhance mobility, and promote overall wellness in a safe and supportive environment.
                  </h6>
                </div>
              </div>
            </div>

           <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('images\heart.jpeg') }}" class="card-img-top" alt="Gaisano Grand Mall Bajada">
                <div class="card-body">
                     <p class="card-text">Heart Center</p>
                  <h6 class="card-title" style="text-align: left;"><strong>Location:</strong>Purok 2, Ulas, Davao City</h6>
                  <h6 style="text-align: center; font-style: italic;">
                    Our Heart Center provides comprehensive cardiovascular care, including diagnosis, treatment, and preventive services for heart-related conditions. With advanced technology and a team of experienced cardiologists, we offer personalized care plans, cardiac rehabilitation, and continuous monitoring to help patients maintain optimal heart health and improve quality of life.
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Contact Us Modal -->
<div class="modal fade" id="contactUsModal" tabindex="-1" aria-labelledby="contactUsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-yellow text-dark">
        <h5 class="modal-title" id="contactUsModalLabel">Contact Us</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <!-- Name -->
          <div class="mb-3">
            <label for="contactName" class="form-label">Name</label>
            <input type="text" class="form-control" id="contactName" placeholder="Your full name">
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="contactEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="contactEmail" placeholder="name@example.com">
          </div>

          <!-- Subject -->
          <div class="mb-3">
            <label for="contactSubject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="contactSubject" placeholder="Subject">
          </div>

          <!-- Message -->
          <div class="mb-3">
            <label for="contactMessage" class="form-label">Message</label>
            <textarea class="form-control" id="contactMessage" rows="4" placeholder="Your message here..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-yellow">Send Message</button>
      </div>
    </div>
  </div>
</div>



<!-- ✅ Find a Doctor -->
<section id="find-doctor" class="find-doctor">
    <div class="container text-center">
        <h5 class="fw-bold text-success mb-3">FIND A DOCTOR</h5>

        <!-- Search Form -->
        <form action="{{ route('home') }}" method="GET" class="row justify-content-center mb-4">
            <div class="col-md-3 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Doctor’s Name or Specialty" value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-select" name="department">
                    <option value="">Select Department</option>
                    <option value="Cardiology" {{ request('department') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                    <option value="Pediatrics" {{ request('department') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                    <option value="Neurology" {{ request('department') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <button class="btn btn-success w-100"><i class="bi bi-search"></i> Search</button>
            </div>
        </form>




<!-- ✅ Digital Services Section -->
<section class="digital-services py-5">
    <div class="container">
        <div class="row text-center">
            <!-- Online Directory -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 bg-success text-white rounded shadow-sm h-100">
                    <i class="bi bi-folder2-open display-4 mb-3"></i>
                    <h5 class="fw-bold">SEARCH OUR HOSPITAL</h5>
                    <p class="mb-3">ONLINE DIRECTORY</p>
                    <a href="{{ route('cards.doctors') }}" class="text-white text-decoration-underline">SEARCH NOW ></a>
                </div>
            </div>

            <!-- Telemedicine -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 bg-white text-success border rounded shadow-sm h-100">
                    <i class="bi bi-laptop display-4 mb-3"></i>
                    <h5 class="fw-bold">HEALTH & WELLNESS</h5>
                    <p class="mb-3">TELEMEDICINE</p>
                    <a href="#" class="text-success text-decoration-underline">READ MORE ></a>
                </div>
            </div>

            <!-- Payment Portal -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 bg-light text-success rounded shadow-sm h-100">
                    <i class="bi bi-credit-card display-4 mb-3"></i>
                    <h5 class="fw-bold">GO TO</h5>
                    <p class="mb-3">PAYMENT PORTAL</p>
                    <a href="#" class="text-success text-decoration-underline">PAY NOW ></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ✅ Welcome Section -->
<section id="welcome" class="welcome-section py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <!-- Text Content -->
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="text-success fw-bold">Welcome to<br>JACKSON DOCTORS HOSPITAL</h2>
                <p class="mt-3">
                    Jackson Hospital is a privately-owned, tertiary level and multi-specialty hospital located in the heart of Davao City, the business hub of Mindanao. Since its foundation in 1969, we have grown into the largest and most modern hospital in Southern Philippines, offering 250 beds and state-of-the-art diagnostic, therapeutic, and intensive care facilities.
                </p>
                <p>
                    We lead in medical specialties including cardiovascular medicine, orthopedics, gastroenterology, endocrinology, neurology, neurosurgery, cancer care, ophthalmology, and liver disease treatment. Patients and practitioners alike trust DDH for comprehensive healthcare.
                </p>
                <a href="#" class="btn btn-warning px-4 py-2 mt-3">ABOUT US</a>
            </div>

            <!-- Carousel -->
            <div class="col-md-6">
                <div id="hospitalCarousel" class="carousel slide shadow rounded" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/operate.jpg') }}" class="d-block w-100 rounded" alt="Operating Room">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/lobby.jpg') }}" class="d-block w-100 rounded" alt="Lobby">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/pharmacy.jpg') }}" class="d-block w-100 rounded" alt="Pharmacy">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/doc1.jpg') }}" class="d-block w-100 rounded" alt="Ambulance">
                        </div>
                    </div>
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#hospitalCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#hospitalCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <!-- Indicators -->
                    <div class="carousel-indicators mt-2">
                        <button type="button" data-bs-target="#hospitalCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#hospitalCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#hospitalCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#hospitalCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- ✅ Patient Services & Centers -->
<section id= "services" class="patient-services py-5" style="background-image: url('{{ asset('images/ddh-care-center.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container bg-white bg-opacity-75 p-5 rounded shadow">
        <div class="text-center mb-5">
            <h6 class="text-muted">WHAT WE DO</h6>
            <h2 class="text-success fw-bold">PATIENT SERVICES & CENTERS</h2>
        </div>

        <div class="row text-center">
            <!-- Row 1 -->
            <div class="col-md-3 mb-4">
                <i class="bi bi-clipboard display-5 text-success mb-2"></i>
                <h6 class="text-muted">MEDICAL RECORDS</h6>
            </div>
            <div class="col-md-3 mb-4">
                <i class="bi bi-cash-coin display-5 text-success mb-2"></i>
                <h6 class="text-muted">FINANCE & BILLINGS</h6>
            </div>
            <div class="col-md-3 mb-4">
                <i class="bi bi-handshake display-5 text-success mb-2"></i>
                <h6 class="text-muted">HMO & CORPORATE PARTNERS</h6>
            </div>
            <div class="col-md-3 mb-4">
                <i class="bi bi-shield-check display-5 text-success mb-2"></i>
                <h6 class="text-muted">HOSPITAL SAFETY</h6>
            </div>

            <!-- Row 2 -->
            <div class="col-md-3 mb-4">
                <i class="bi bi-eyedropper display-5 text-success mb-2"></i>
                <h6 class="text-muted">LABORATORY & DIAGNOSTICS</h6>
            </div>
            <div class="col-md-3 mb-4">
                <i class="bi bi-person-badge display-5 text-success mb-2"></i>
                <h6 class="text-muted">NURSING SERVICE</h6>
            </div>
            <div class="col-md-3 mb-4">
                <i class="bi bi-house-heart display-5 text-success mb-2"></i>
                <h6 class="text-muted">CARE CENTERS</h6>
            </div>
            <div class="col-md-3 mb-4">
                <i class="bi bi-person-walking display-5 text-success mb-2"></i>
                <h6 class="text-muted">OUT PATIENT DEPARTMENT</h6>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-warning px-4 py-2 fw-bold">OUR SERVICES ></a>
        </div>
</div>
</section>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/landing.js') }}"></script>
@endsection