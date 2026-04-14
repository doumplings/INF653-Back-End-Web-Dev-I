const fs = require("fs");
const path = require("path");

const data = {
  employees: require("../model/employees.json"),
  setEmployees: function (employees) {
    this.employees = employees;
  },
};

const employeesFilePath = path.join(__dirname, "..", "model", "employees.json");

const persistEmployees = async (employees) => {
  await fs.promises.writeFile(
    employeesFilePath,
    JSON.stringify(employees, null, 2),
  );
};

// Get all employees
const getAllEmployees = (req, res) => {
  res.json(data.employees);
};

// Create employee
const createNewEmployee = async (req, res, next) => {
  try {
    const { firstname, lastname } = req.body;

    if (!firstname || !lastname) {
      return res
        .status(400)
        .json({ message: "First name and last name are required." });
    }

    const newEmployee = {
      id: data.employees.length
        ? Number(data.employees[data.employees.length - 1].id) + 1
        : 1,
      firstname,
      lastname,
    };

    const updatedEmployees = [...data.employees, newEmployee];
    data.setEmployees(updatedEmployees);
    await persistEmployees(updatedEmployees);

    res.status(201).json(newEmployee);
  } catch (error) {
    next(error);
  }
};

// Update employee
const updateEmployee = async (req, res, next) => {
  try {
    const employeeId = Number(req.body.id ?? req.params.id);

    if (!employeeId) {
      return res.status(400).json({ message: "Employee id is required." });
    }

    const employee = data.employees.find(
      (emp) => Number(emp.id) === employeeId,
    );

    if (!employee) {
      return res
        .status(404)
        .json({ message: `Employee ID ${employeeId} not found.` });
    }

    if (req.body.firstname) {
      employee.firstname = req.body.firstname;
    }

    if (req.body.lastname) {
      employee.lastname = req.body.lastname;
    }

    const updatedEmployees = data.employees.map((emp) =>
      Number(emp.id) === employeeId ? employee : emp,
    );

    data.setEmployees(updatedEmployees);
    await persistEmployees(updatedEmployees);

    res.json(employee);
  } catch (error) {
    next(error);
  }
};

// Delete employee
const deleteEmployee = async (req, res, next) => {
  try {
    const employeeId = Number(req.body.id ?? req.params.id);

    if (!employeeId) {
      return res.status(400).json({ message: "Employee id is required." });
    }

    const employee = data.employees.find(
      (emp) => Number(emp.id) === employeeId,
    );

    if (!employee) {
      return res
        .status(404)
        .json({ message: `Employee ID ${employeeId} not found.` });
    }

    const updatedEmployees = data.employees.filter(
      (emp) => Number(emp.id) !== employeeId,
    );

    data.setEmployees(updatedEmployees);
    await persistEmployees(updatedEmployees);

    res.json(employee);
  } catch (error) {
    next(error);
  }
};

// Get employee by id
const getEmployee = (req, res) => {
  const employeeId = Number(req.params.id);

  if (!employeeId) {
    return res.status(400).json({ message: "Employee id is required." });
  }

  const employee = data.employees.find((emp) => Number(emp.id) === employeeId);

  if (!employee) {
    return res
      .status(404)
      .json({ message: `Employee ID ${employeeId} not found.` });
  }

  res.json(employee);
};

module.exports = {
  getAllEmployees,
  createNewEmployee,
  updateEmployee,
  deleteEmployee,
  getEmployee,
};
