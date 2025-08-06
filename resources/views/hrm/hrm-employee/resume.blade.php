<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Resume</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html {
            height: 100%;
        }
        body {
            min-height: 100%;
            background: #eee;
            font-family: 'Lato', sans-serif;
            font-weight: 400;
            color: #222;
            font-size: 14px;
            line-height: 26px;
            padding-bottom: 50px;
        }
        .container {
            max-width: 700px;
            background: #fff;
            margin: 0px auto 0px;
            box-shadow: 1px 1px 2px #DAD7D7;
            border-radius: 3px;
            padding: 40px;
            margin-top: 50px;
        }
        .header {
            margin-bottom: 30px;
        }
        .full-name {
            font-size: 40px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .first-name {
            font-weight: 700;
        }
        .last-name {
            font-weight: 300;
        }
        .contact-info {
            margin-bottom: 20px;
        }
        .email, .phone {
            color: #999;
            font-weight: 300;
        }
        .separator {
            height: 10px;
            display: inline-block;
            border-left: 2px solid #999;
            margin: 0px 10px;
        }
        .position {
            font-weight: bold;
            display: inline-block;
            margin-right: 10px;
            text-decoration: underline;
        }
        .details {
            line-height: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section:last-of-type {
            margin-bottom: 0px;
        }
        .section__title {
            letter-spacing: 2px;
            color: #54AFE4;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .section__list-item {
            margin-bottom: 40px;
        }
        .section__list-item:last-of-type {
            margin-bottom: 0;
        }
        .left, .right {
            vertical-align: top;
            display: inline-block;
        }
        .left {
            width: 60%;
        }
        .right {
            text-align: right;
            width: 39%;
        }
        .name {
            font-weight: bold;
        }
        a {
            text-decoration: none;
            color: #000;
            font-style: italic;
        }
        a:hover {
            text-decoration: underline;
            color: #000;
        }
        .skills {
        }
        .skills__item {
            margin-bottom: 10px;
        }
        .skills__item .right {
            input {
                display: none;
            }
            label {
                display: inline-block;
                width: 20px;
                height: 20px;
                background: #C3DEF3;
                border-radius: 20px;
                margin-right: 3px;
            }
            input:checked + label {
                background: #79A9CE;
            }
        }
    </style>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="full-name">
                <span class="first-name">{{ $employee->_name ?? '' }}</span>
                <span class="last-name">{{ $employee->_last_name ?? '' }}</span>
            </div>
            <div class="contact-info">
                <span class="email">Email: </span>
                <span class="email-val">{{ $employee->_email ?? '' }}</span>
                <span class="separator"></span>
                <span class="phone">Phone: </span>
                <span class="phone-val">{{ $employee->_mobile1 ?? '' }}</span>
            </div>
            <div class="about">
                <span class="position">{{ optional($employee->_emp_designation)->_name ?? '' }}</span>
                <span class="desc">
                    {{ $employee->_bio ?? '' }}
                </span>
            </div>
        </div>

        <!-- Experience Section -->
        <div class="section">
            <div class="section__title">Experience</div>
            <div class="section__list">
                @if ($employee->hrm_experiences->isNotEmpty())
                    @foreach ($employee->hrm_experiences as $exp)
                        <div class="section__list-item">
                            <div class="left">
                                <div class="name">{{ $exp->_company ?? '' }}</div>
                                <div class="addr">{{ $exp->_company_location ?? '' }}</div>
                                <div class="duration">{{ $exp->_wfrom ?? '' }} - {{ $exp->_wto ?? '' }}</div>
                            </div>
                            <div class="right">
                                <div class="name">{{ $exp->_designation ?? '' }}</div>
                                <div class="desc">{{ $exp->_note ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No experience data available.</p>
                @endif
            </div>
        </div>

        <!-- Education Section -->
        <div class="section">
            <div class="section__title">Education</div>
            <div class="section__list">
                @if ($employee->_hrm_education->isNotEmpty())
                    @foreach ($employee->_hrm_education as $edu)
                        <div class="section__list-item">
                            <div class="left">
                                <div class="name">{{ $edu->_subject ?? '' }}</div>
                                <div class="addr">{{ $edu->_institute ?? '' }}</div>
                                <div class="duration">{{ $edu->_year ?? '' }}</div>
                            </div>
                            <div class="right">
                                <div class="name">{{ $edu->_score ?? '' }}</div>
                                <div class="desc">{{ $edu->_description ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No education data available.</p>
                @endif
            </div>
        </div>

        <!-- Languages Section -->
        <div class="section">
            <div class="section__title">Languages</div>
            <div class="section__list">
                @if ($employee->_hrm_languages->isNotEmpty())
                    @foreach ($employee->_hrm_languages as $language)
                        <div class="section__list-item">
                            <div class="name">{{ $language->_language ?? '' }}</div>
                            <div class="desc">{{ $language->_proficiency ?? '' }}</div>
                        </div>
                    @endforeach
                @else
                    <p>No languages data available.</p>
                @endif
            </div>
        </div>

        <!-- Address Section -->
        <div class="section">
            <div class="section__title">Addresses</div>
            <div class="section__list">
                @if ($employee->hrm_empaddresses->isNotEmpty())
                    @foreach ($employee->hrm_empaddresses as $address)
                        <div class="section__list-item">
                            <div class="left">
                                <div class="name">{{ $address->_address ?? '' }}</div>
                                <div class="addr">{{ $address->_city ?? '' }}</div>
                                <div class="duration">{{ $address->_state ?? '' }}</div>
                            </div>
                            <div class="right">
                                <div class="name">{{ $address->_zipcode ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No address data available.</p>
                @endif
            </div>
        </div>

        <!-- Emergency Contacts Section -->
        <div class="section">
            <div class="section__title">Emergency Contacts</div>
            <div class="section__list">
                @if ($employee->hrm_emergencies->isNotEmpty())
                    @foreach ($employee->hrm_emergencies as $emergency)
                        <div class="section__list-item">
                            <div class="name">{{ $emergency->_contact_name ?? '' }}</div>
                            <div class="desc">{{ $emergency->_relationship ?? '' }} - {{ $emergency->_contact_phone ?? '' }}</div>
                        </div>
                    @endforeach
                @else
                    <p>No emergency contact data available.</p>
                @endif
            </div>
        </div>

    </div>
</body>
</html
