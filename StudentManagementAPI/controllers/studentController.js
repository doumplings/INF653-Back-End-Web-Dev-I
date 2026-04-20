import mongoose from "mongoose";
import Student from "../models/studentModel.js";

const isValidObjectId = (id) => mongoose.Types.ObjectId.isValid(id);

const sendServerError = (res, error) => {
  res.status(500).json({ message: "Server error", error: error.message });
};

export const getAllStudents = async (req, res) => {
  try {
    const students = await Student.find().sort({ enrolledDate: -1 });
    res.status(200).json(students);
  } catch (error) {
    sendServerError(res, error);
  }
};

export const getStudentById = async (req, res) => {
  const { id } = req.params;

  if (!isValidObjectId(id)) {
    return res.status(400).json({ message: "Invalid student id" });
  }

  try {
    const student = await Student.findById(id);

    if (!student) {
      return res.status(404).json({ message: "Student not found" });
    }

    return res.status(200).json(student);
  } catch (error) {
    return sendServerError(res, error);
  }
};

export const createStudent = async (req, res) => {
  const { firstName, lastName, email, course, enrolledDate } = req.body;

  if (!firstName || !lastName || !email || !course) {
    return res.status(400).json({
      message: "firstName, lastName, email, and course are required",
    });
  }

  try {
    const student = await Student.create({
      firstName,
      lastName,
      email,
      course,
      enrolledDate,
    });

    return res.status(201).json(student);
  } catch (error) {
    if (error?.code === 11000) {
      return res.status(409).json({ message: "Email already exists" });
    }

    if (error.name === "ValidationError") {
      return res.status(400).json({ message: error.message });
    }

    return sendServerError(res, error);
  }
};

export const updateStudent = async (req, res) => {
  const { id, firstName, lastName, email, course, enrolledDate } = req.body;

  if (!id) {
    return res
      .status(400)
      .json({ message: "Student id is required in request body" });
  }

  if (!isValidObjectId(id)) {
    return res.status(400).json({ message: "Invalid student id" });
  }

  const updates = {};

  if (firstName !== undefined) updates.firstName = firstName;
  if (lastName !== undefined) updates.lastName = lastName;
  if (email !== undefined) updates.email = email;
  if (course !== undefined) updates.course = course;
  if (enrolledDate !== undefined) updates.enrolledDate = enrolledDate;

  if (Object.keys(updates).length === 0) {
    return res.status(400).json({ message: "No fields provided for update" });
  }

  try {
    const updatedStudent = await Student.findByIdAndUpdate(id, updates, {
      new: true,
      runValidators: true,
    });

    if (!updatedStudent) {
      return res.status(404).json({ message: "Student not found" });
    }

    return res.status(200).json(updatedStudent);
  } catch (error) {
    if (error?.code === 11000) {
      return res.status(409).json({ message: "Email already exists" });
    }

    if (error.name === "ValidationError") {
      return res.status(400).json({ message: error.message });
    }

    return sendServerError(res, error);
  }
};

export const deleteStudent = async (req, res) => {
  const { id } = req.body;

  if (!id) {
    return res
      .status(400)
      .json({ message: "Student id is required in request body" });
  }

  if (!isValidObjectId(id)) {
    return res.status(400).json({ message: "Invalid student id" });
  }

  try {
    const deletedStudent = await Student.findByIdAndDelete(id);

    if (!deletedStudent) {
      return res.status(404).json({ message: "Student not found" });
    }

    return res.status(200).json({
      message: "Student deleted successfully",
      student: deletedStudent,
    });
  } catch (error) {
    return sendServerError(res, error);
  }
};
