<?php
$content = array(
    'description' => 'Senior System Specialist',
    'about_us' => '<p>Professional with solid academic background and over 19 years of experience in software development, with emphasis on distributed systems and robust backend solutions. Bachelor\'s degree in Information Systems, with specializations in Distributed Systems (UFBA) and Mobile Application Development (IFBA).</p>
                   <p>He has worked in large companies such as Marinha do Brasil, Portugal Telecom, Meta, Invillia and is currently a Software Specialist at Ericsson Inovação S/A. He has extensive knowledge of Java, Spring, software architecture, systems integration and modern DevOps practices.</p>
                   <p>His career highlights include his work on strategic projects such as the migration of approximately 12 million lines from Oi to Vivo, and the implementation of payment via PIX in one of the largest e-commerces in the country.</p>
                   <p>Committed to technical excellence, innovation and delivery of value to the customer, he is always seeking continuous evolution and best development practices.</p>',
    'contact' => 'Contact',
    'nav' => array(
        'itens' => array(
            array(
                'name' => 'EXPERIENCE',
                'link' => '#experience'
            ),
            array(
                'name' => 'FORMATION',
                'link' => '#education'
            ),
            array(
                'name' => 'SKILLS',
                'link' => '#skills'
            ),
            array(
                'name' => 'COURSES',
                'link' => '#awards'
            ),
            array(
                'name' => 'PROJECTS',
                'link' => '#projects'
            ),
            array(
                'name' => 'ARTICLES',
                'link' => 'http://www.isacaguiar.com.br/blog/'
            ),
        )
    ),
    'experience' => array(
        'title' => 'Professional experience',
        'jobs' => array(
            array(
                'title' => 'Specialist in Systems Development',
                'company' => 'EISA',
                'link' => 'https://jobs.kenoby.com/eisa',
                'position' => 'Backend Developer',
                'notes' => '<h4>SmartSim Project – Customer Provisioning</h4>
                            <p>• Acting as technical leader and developer</p>
                            <p>• Development of a centralizing API for activation orders on Vivo platforms.</p>
                            <p>• Technologies: Java 8, Spring Boot, Eureka, Kafka, Oracle, Linux.</p>
                            <h4>JERI Project – Migration of Oi Móvel Lines to Vivo (January 2022 to May 2023)</h4>
                            <p>• Acting as technical leader and developer in a large-scale national project, in the process of migrating Oi lines to Vivo.</p>
                            <p>• Implementation of ingestion and processing of CSV files with data validation and business logic based on comparison algorithms.</p>
                            <p>• Technologies: Java, PL/SQL, GitLab, Linux, Oracle..</p>',
                'period' => 'January 2022 - Present'
            ),
            array(
                'title' => 'Developer',
                'company' => 'Invillia',
                'link' => 'https://www.invillia.com',
                'position' => 'Backend Developer',
                'notes' => '<h4>OLX (Outsourcing)</h4>
                            <p>• Payments squad with 6 developers, responsible for the financial flow of transactions between users.</p>
                            <p>• Integrations with Matera (card) and FlagShip (PIX) APIs. Participation in the start of the OLX Card project.</p>
                            <p>• Technologies: Java 11, Spring Boot, AWS (SQS/SNS, CloudWatch), Elasticsearch, Terraform, Node.js, Kong.</p>',
                'period' => 'April 2021 - January 2022'
            ),
            array(
                'title' => 'Java Developer',
                'company' => 'Meta',
                'link' => 'https://www.meta.com.br',
                'position' => 'Technical Leader',
                'notes' => '<h4>TACWEB Project</h4>
                            <p>• Technical leader of a team with 5 devs and 1 tester. Development of a fleet tracking platform.</p>
                            <p>• Location monitoring, real-time alerts and control of drivers and passengers.</p>
                            <p>• Technologies: Java, REST, Hibernate, AngularJS, SQL Server.</p>',
                'period' => 'October 2020 - April 2021'
            ),
            array(
                'title' => 'Fullstack Developer',
                'company' => 'LexConsult',
                'link' => 'https://lextax.com.br/',
                'position' => 'Consultant',
                'notes' => '<p>• Worked on the development of SGTLex, a solution aimed at tax auditing and fiscal governance, with a focus on operational security and compliance with tax intelligence.</p>
                            <p>• The system offers advanced resources for viewing and analyzing tax data, helping companies make strategic decisions based on governance rules specific to complex sectors of the economy.M</p>
                            <p>• Backend development in Java with Spring Boot, with a focus on performance and scalability.</p>
                            <p>• Frontend development in React, with emphasis on the creation of reusable components, optimizing productivity and standardization among team developers.</p>',
                'period' => 'January 2020 - October 2020'
            ),
            array(
                'title' => 'Systems Analyst (Developer)',
                'company' => 'Acp Group Technology',
                'link' => 'http://www.acpgroup.com.br',
                'position' => 'Web Solutions Development',
                'notes' => '<p>• Development of web solutions for FIPLAN (Planning and Finance System of the State of Bahia).</p>
                            <p>• Technical support and guidance for junior developers. Technologies: Java, Struts, Hibernate, Oracle, JavaScript.</p>',
                'period' => 'January 2020 - October 2020'
            ),
            array(
                'title' => 'Technical Officer',
                'company' => 'Brazilian Navy',
                'link' => 'http://www.marinha.mil.br',
                'position' => 'Information Technology and Communications Manager: Responsible for managing IT and communications projects and operations, including system development and integration using high technology, identifying application opportunities according to strategic needs.',
                'notes' => '<p>• IT and communications management. Information and Communications Security Officer.</p>
                            <p>• Network, server, internal systems and institutional communication administration.</p>
                            <p>• Technologies: Java, Spring, Struts, Hibernate, PHP, HTML, CSS, JavaScript, Oracle, MySQL.</p>',
                'period' => 'January 2012 - January 2020'
            ),
            array(
                'title' => 'Teacher',
                'company' => 'FAC FUNAM - Higher Educational Foundation of Alto Médio São Francisco',
                'link' => 'http://facfunam.edu.br/',
                'position' => 'Professor of the Higher Course in Systems Analysis and Development.',
                'notes' => '<b>Subjects:</b> Organization Automation; Software Engineering I, II, III; Project Management; and Software Quality. Member of the NDE (Structuring Teaching Nucleus).',
                'period' => 'November 2008 - January 2012'
            ),
            array(
                'title' => 'INFORMATION AND COMMUNICATION TECHNOLOGY ANALYST',
                'company' => 'Altice Portugal - SI/IT and Innovation Telecommunications',
                'link' => 'https://www.telecom.pt/pt-pt',
                'position' => 'Understand and apply software engineering disciplines and organizational activities. Provide architecture, design, development, maintenance, and testing of systems in the field of information and communication technology. Feasibility study of project creation, regarding the use of necessary resources for application development. Identify the functions that will be delivered upon completing the application. Guide analysts, developers, and interns in developing innovative projects in the areas of IT and communications.',
                'notes' => 'Java, Spring, Rest, Soap, Hibernate, Struts, HTML, CSS, JavaScript, Ajax, JQuery, Oracle, PLSQL, and ETL.',
                'period' => 'November 2008 - January 2012'
            ),
            array(
                'title' => 'TECHNOLOGICAL PROFESSOR LEVEL 1',
                'company' => 'Baiano Institute of Higher Education',
                'link' => 'https://uniceusa.edu.br/',
                'position' => 'Professor of the Systems Analysis and Development Course.',
                'notes' => '<b>Subject:</b> Systems Design and Development.',
                'period' => 'January 2011 - May 2011'
            ),
            array(
                'title' => 'Systems Analyst',
                'company' => 'Stefanini',
                'link' => 'https://stefanini.com/pt-br',
                'position' => 'Analysis, design, architecture, development, maintenance, and testing of systems.',
                'notes' => '<p>• Development of the SIGIP system for the Civil Police of Bahia. Participation in the first Digital Police Station in the state.</p>
                            <p>• Technologies: Java, Spring MVC, Hibernate, REST, PL/SQL, HTML, JavaScript, Oracle.</p>',
                'period' => 'January 2008 - November 2008'
            ),
            array(
                'title' => 'DEVELOPER ANALYST I',
                'company' => 'SYSDESIGN CONSULTORIA EM INFORMÁTICA LTDA',
                'link' => 'https://sysdesign.com.br/',
                'position' => '<p>• Experience in the complete systems development cycle.</p>
                               <p>• Technologies: Java, Hibernate, ASP, JavaScript, SQL, Oracle, MySQL, PostgreSQL.</p>',
                'notes' => 'Java EE, JSP/Servlets, JSTL, JSF 2, JPA, Hibernate 3, Struts, ASP, Oracle Forms, Oracle Reports, HTML, CSS, JavaScript, Ajax, Oracle, SQL Server, PostgreSQL.',
                'period' => 'December 2004 - January 2008'
            )
        )
    ),
    'education' => array(
        'title' => 'EDUCATION',
        'formations' => array(
            array(
                'degree' => 'POST-GRADUATE LATO SENSU IN DEVELOPMENT OF APPLICATIONS AND GAMES FOR MOBILE DEVICES',
                'institution' => 'IFBA - FEDERAL INSTITUTE OF BAHIA',
                'period' => 'January 2020 - July 2022',
                'link' => 'http://www.prpgi.ifba.edu.br/'
            ),
            array(
                'degree' => 'ADVANCED SPECIALIZATION IN DISTRIBUTED SYSTEMS',
                'institution' => 'UFBA - FEDERAL UNIVERSITY OF BAHIA',
                'period' => 'January 2008 - July 2010',
                'link' => 'http://www.lasid.ufba.br/'
            ),
            array(
                'degree' => 'BACHELOR OF SCIENCE IN INFORMATION SYSTEMS',
                'institution' => 'ESTÁCIO UNIVERSITY CENTER OF BAHIA',
                'period' => 'January 2002 - July 2007',
                'link' => 'https://portal.estacio.br/unidades/centro-universit%C3%A1rio-est%C3%A1cio-da-bahia/cursos/gradua%C3%A7%C3%A3o/bacharelado-e-licenciatura/sistemas-de-informa%C3%A7%C3%A3o/'
            )
        )
    ),
    'skills' => array(
        'title' => 'SKILLS',
        'categories' => array(
            array(
                'name' => 'Programming Languages and Tools',
                'itens' => array(
                    array(
                        'name' => 'Java',
                        'icon' => 'fab fa-java',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'HTML 5',
                        'icon' => 'fab fa-html5',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'CSS 3',
                        'icon' => 'fab fa-css3-alt',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'JavaScript',
                        'icon' => 'fab fa-js-square',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'Bootstrap',
                        'icon' => 'fab fa-bootstrap',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'jQuery',
                        'icon' => 'fab fa-html5',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'Angular',
                        'icon' => 'fab fa-angular',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'React',
                        'icon' => 'fab fa-react',
                        'icon_title' => ''
                    ),
                    array(
                        'name' => 'Node.js',
                        'icon' => 'fab fa-node-js',
                        'icon_title' => ''
                    )
                )
            ),
            array(
                'name' => 'Workflow',
                'itens' => array(
                    array(
                        'name' => 'Responsive Design',
                        'icon' => 'fas fa-wand-sparkles',
                        'icon_title' => 'Responsive Design'
                    ),
                    array(
                        'name' => 'Multifunctional Teams',
                        'icon' => 'fas fa-swatchbook',
                        'icon_title' => 'Multifunctional Teams'
                    ),
                    array(
                        'name' => 'Agile Development and Scrum',
                        'icon' => 'fas fa-pills',
                        'icon_title' => 'Agile Development and Scrum'
                    )
                )
            )
        )
    ),
    'awards' => array(
        'title' => 'Certificações e Cursos',
        'courses' => array(
            array(
                'course' => 'Scrum Fundamentals Certified (SFC)',
                'institution' => 'SCRUMstudy',
                'link' => 'http://81cd1176253f3f59d435-ac22991740ab4ff17e21daf2ed577041.r77.cf1.rackcdn.com/Certificates/ScrumFundamentalsCertified-IsacVelozodeCastroAguiar-724346.pdf',
                'duration' => '',
                'year' => '2019',
                'icon' => 'fa-certificate'
            ),
            array(
                'course' => 'Formação Angular 10 - O início criando 7 projetos',
                'institution' => 'Udemy',
                'link' => 'https://www.udemy.com',
                'duration' => '11 hours',
                'year' => '2020',
                'icon' => 'fa-code'
            ),
            array(
                'course' => 'Web Design',
                'institution' => 'Transnology Ltda',
                'link' => '#',
                'duration' => '80 hours',
                'year' => '2004',
                'icon' => 'fa-code'
            ),
            array(
                'course' => 'Lógica de Programação com Delphi 5.0',
                'institution' => 'SENAI - Departamento Regional da Bahia',
                'link' => 'http://www.fieb.org.br/senai/',
                'duration' => '80 hours',
                'year' => '2002',
                'icon' => 'fa-code'
            ),
            array(
                'course' => 'Especial de Qualificação de Docentes',
                'institution' => 'Marinha do Brasil',
                'link' => 'http://www.marinha.mil.br',
                'duration' => 'Carga horária: 170 hours',
                'year' => '2019',
                'icon' => 'fa-graduation-cap'
            ),
            array(
                'course' => 'course Expedito de Certificação de Auditores em SID em Redes Locais de Computador',
                'institution' => 'Marinha do Brasil',
                'link' => 'http://www.marinha.mil.br',
                'duration' => '70 hours',
                'year' => '2015',
                'icon' => 'fa-graduation-cap'
            )
        )
    ),
    'projects' => array(
        'title' => 'Projects/Portfolio',
        'itens' => array(
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/real.png',
                'project' => 'Real Innovation',
                'technologies' => 'Java 11, Spring Boot, MySQL, Maven.',
                'description' => 'Full Stack development',
                'links' => ['https://realinnovation.com.br/', 'https://app.realinnovation.com.br/']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/vivo2.jpg',
                'project' => 'SmartSim',
                'technologies' => 'Java 8, Spring Boot, Oracle, Maven.',
                'description' => 'Backend Developer',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/vivo2.jpg',
                'project' => 'Project Jeri',
                'technologies' => 'Java 8, Spring Boot, Oracle, Maven.',
                'description' => 'Full Stack development',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/olx.jpg',
                'project' => 'OLX - Payments',
                'technologies' => 'Java 11, Spring Boot, AWS, Docker, Maven, Node, Terraform, Grafana, New Relic.',
                'description' => 'Backend Developer',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/tacweb.jpg',
                'project' => 'Tacweb',
                'technologies' => 'Java 8, Rest, Hibernate, AngularJS, SQL Server.',
                'description' => 'Technical Leader',
                'links' => []

            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/navegueamador.jpg',
                'project' => 'Nautical School Navegue Amador',
                'technologies' => 'PHP, HTML5, CSS3, Bootstrap.',
                'description' => 'Project and development',
                'links' => ['http://www.escolanauticanavegueamador.com.br']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/fiplan.jpg',
                'project' => 'FIPLAN',
                'technologies' => 'Java 8, Spring, Struts, Hibernate, VUE, Ajax, JQuery, JS, HTML, CSS, Ant and Oracle.',
                'description' => 'Full stack development',
                'links' => ['http://www.prodeb.gov.br/servicos/FIPLAN.aspx']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/sgtlex.jpg',
                'project' => 'SGTLEX',
                'technologies' => 'Java, Spring, React, TS, Bootstrap, HTML, CSS e Oracle.',
                'description' => 'Full stack development',
                'links' => ['https://lextax.com.br/sgtlex/', 'https://novemax.com.br/lex/']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/fenix.jpg',
                'project' => 'FENIX',
                'technologies' => 'Java, SOAP, Rest, Maven e XML.',
                'description' => 'Project and development',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/apkomp.jpg',
                'project' => 'APKomp',
                'technologies' => 'PHP, Bootstrap, HTML, CSS JQuery.',
                'description' => 'Project and development',
                'links' => ['http://apkomp.com.br/']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/histocito.jpg',
                'project' => 'Histocito',
                'technologies' => 'PHP, Bootstrap, Jquery e MySQL.',
                'description' => 'Project and development',
                'links' => ['http://isacaguiar.com.br/histocito']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/delpira.jpg',
                'project' => 'Del Pirapora',
                'technologies' => 'Drupal 8.',
                'description' => 'Project and development',
                'links' => ['https://www.marinha.mil.br/om/delegacia-fluvial-de-pirapora']
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/delpira_intranet.jpg',
                'project' => 'Intranet Del Pirapora',
                'technologies' => 'PHP, Bootstrap, HTML, CSS, JQuery e MySQL.',
                'description' => 'Project and development',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/quadro_presenca.jpg',
                'project' => 'Quadro de Presença',
                'technologies' => 'PHP, Bootstrap, HTML, CSS, JQuery e MySQL.',
                'description' => 'Project and development',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/vivo.jpg',
                'project' => 'Portal Corporativo',
                'technologies' => 'Java, SOAP, Spring, JSF, Struts, Maven e Oracle.',
                'description' => 'Project and development',
                'links' => []
            ),
            array(
                'image' => 'http://isacaguiar.com.br/cv/assets/img/portfolio/sigip.jpg',
                'project' => 'SIGIP - Sistema de Informação e Gestão Integrada Policial',
                'technologies' => 'Java, Struts, Hibernate, Ant e SQLServer.',
                'description' => 'Full stack development',
                'links' => []
            )
        )
    )
);
?>