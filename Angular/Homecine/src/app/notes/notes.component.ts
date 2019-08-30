import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Note} from '../note';
import {NotesService} from '../notes.service';

@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.css']
})
export class NotesComponent implements OnInit {

  notes: Note[] = [];

  constructor(private route: ActivatedRoute, private noteService: NotesService) { }

  ngOnInit() {
    this.getNotes();
  }

  getNotes() {
    this.noteService.getAllNotes().subscribe((notes) => this.notes = notes);
  }

  deleteNote(id: number): void {
    this.noteService.deleteNoteById(id)
      .subscribe(_ => {
        this.getNotes();
      });
  }

}
