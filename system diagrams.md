# PRV Tracking System - System Diagrams

Here are the diagrams for your report. They are written using **Mermaid** syntax, which you can easily copy and paste into tools like [Mermaid Live Editor](https://mermaid.live/), Notion, GitHub, or use as a reference to recreate them in Draw.io / Visio.

> [!IMPORTANT]
> All diagrams reflect the actual codebase. Only **Admin** and **Staff** users can access the system. Students, Supervisors, and Examiners are data records managed by Admin/Staff — they do not interact with the system directly.

---

## 1. System Flowchart (Core Process)
This flowchart shows the step-by-step lifecycle of how Admin/Staff tracks a student's Postgraduate Research & Viva journey in the system.

```mermaid
graph TD
    Start(["Start: Admin Registers Student"]) --> AssignSup["Assign Main & Co-Supervisors"]
    AssignSup --> RecordThesis[/"Record Thesis Submission Details"/]
    RecordThesis --> Turnitin[/"Record Turnitin Report & Percentage"/]
    Turnitin --> AssignExam["Assign Internal & External Examiners"]
    AssignExam --> TrackPanel["Track Panel Confirmation Status"]
    TrackPanel --> DistDraft[/"Record Thesis Distribution to Panel"/]
    DistDraft --> SchedViva[/"Schedule Viva Date & Send Invitations"/]
    SchedViva --> RecordViva[/"Record Viva Result"/]
    RecordViva --> Result{"Viva Result?"}

    Result -->|"Pass - No Corrections"| Senate[/"Record Senate & JIL Approval"/]
    Result -->|"Minor/Major Corrections"| Corrections["Track Post-Viva Corrections"]
    Result -->|"Re-Viva"| SchedViva
    Result -->|"Fail"| EndFail(["End: Failed"])

    Corrections --> TrackCorr[/"Record Corrected Thesis & Endorsements"/]
    TrackCorr --> ExamEndorse[/"Record Examiner Endorsement"/]
    ExamEndorse --> FinalResult[/"Record Final Result"/]
    FinalResult --> Senate

    Senate --> FinalDocs[/"Record Final Document Submissions"/]
    FinalDocs --> SentPSB[/"Record Sent to PSB"/]
    SentPSB --> Grad(["End: Graduation Date Recorded"])
```

---

## 2. Context Diagram (Diagram 0)
The Context Diagram gives a high-level view of the entire PRV Tracking System. Since only Admin/Staff access the system, there is a single external entity.

```mermaid
graph LR
    %% External Entity
    Staff["Admin / Staff"]

    %% Central System
    System(("0. PRV\nTracking System"))

    %% Data Flows - Input
    Staff -- "Login Credentials\nStudent Registration Data\nStudent Record Updates\nSupervisor & Examiner Data\nViva Schedule & Panel Details\nCorrection Tracking Data\nGraduation & Senate Data\nUser Account Data\nImport File - Excel" --> System

    %% Data Flows - Output
    System -- "Dashboard Statistics\nAction Required Alerts\nPending Response Alerts\nStudent Details & Search Results\nExported Reports - PDF & Excel" --> Staff
```

---

## 3. Level 1 Data Flow Diagram (DFD)
The Level 1 DFD breaks down the Context Diagram into the primary sub-processes and shows how data moves between processes and data stores. All processes are performed by Admin/Staff.

```mermaid
graph TD
    %% External Entity
    Staff["Admin / Staff"]

    %% 1.0 Manage User Accounts
    Staff -- "User Account Data" --> P1["1.0\nManage User Accounts"]
    P1 -- "User Records" --> D1[["D1: Users"]]
    D1 -. "Login Credentials" .-> P1
    P1 -- "Login Confirmation" --> Staff

    %% 2.0 Register Student Records
    Staff -- "Student, Supervisor\n& Examiner Data" --> P2["2.0\nRegister Student Records"]
    P2 -- "Student Records" --> D2[["D2: Students,\nSupervisors & Examiners"]]
    D2 -. "Student Info" .-> P2
    P2 -- "Student Details" --> Staff

    %% 3.0 Manage Viva Process
    Staff -- "Viva & Panel Details" --> P3["3.0\nManage Viva Process"]
    D2 -. "Student & Examiner Info" .-> P3
    P3 -- "Viva Records" --> D3[["D3: Viva Records"]]

    %% 4.0 Track Corrections
    Staff -- "Correction Data" --> P4["4.0\nTrack Corrections"]
    D3 -. "Viva Result" .-> P4
    P4 -- "Correction Records" --> D4[["D4: Corrections"]]

    %% 5.0 Process Graduation
    Staff -- "Senate & Graduation Data" --> P5["5.0\nProcess Graduation"]
    D4 -. "Final Result" .-> P5
    P5 -- "Graduation Records" --> D5[["D5: Graduation"]]

    %% 6.0 Generate Reports
    Staff -- "Report Request / Export" --> P6["6.0\nGenerate Reports"]
    D2 -. "Student Data" .-> P6
    D3 -. "Viva Data" .-> P6
    D4 -. "Correction Data" .-> P6
    D5 -. "Graduation Data" .-> P6
    P6 -- "PDF / Excel Reports\nDashboard Statistics" --> Staff
```

*(Note: In standard DFD notation, circles represent processes, open rectangles/cylinders represent data stores, and squares represent external entities. Dashed lines represent read operations.)*

---

## 4. Use Case Diagram
This diagram shows the system's functionalities from the perspective of the two actors: Admin and Staff. Admin has full access, while Staff has read-only access to student records and reports.

```mermaid
graph LR
    %% Actors
    Admin(["Admin"])
    Staff(["Staff"])

    %% System Boundary
    subgraph PRV Tracking System
        UC1(["Login / Logout"])
        UC2(["Manage Own Profile"])
        UC3(["Register New Student"])
        UC4(["Edit / Delete Student Records"])
        UC5(["Manage Supervisors & Examiners"])
        UC6(["Record Viva Details & Results"])
        UC7(["Track Post-Viva Corrections"])
        UC8(["Record Graduation & Senate Data"])
        UC9(["Search & View Student Details"])
        UC10(["Export Reports - PDF & Excel"])
        UC11(["View Dashboard & Statistics"])
        UC12(["Manage User Accounts"])
        UC13(["Import Students via Excel"])
        UC14(["Bulk Delete Students"])
    end

    %% Admin has full access
    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14

    %% Staff has limited access (view/search/export only)
    Staff --> UC1
    Staff --> UC2
    Staff --> UC9
    Staff --> UC10
```

---

### Tips for your report:
- **Flowchart**: Useful for explaining the logical sequence of events in the student tracking lifecycle.
- **Diagram 0 (Context)**: Put this in the introduction of your system architecture section to show the system's boundaries. Only Admin/Staff interact with the system directly.
- **DFD Level 1**: Use this to show how data is routed and stored across the 7 database tables (`users`, `students`, `supervisors`, `examiners`, `viva_records`, `corrections`, `graduation`).
- **Use Case**: Best used in the requirements gathering section to show what features were built for Admin vs Staff roles.
