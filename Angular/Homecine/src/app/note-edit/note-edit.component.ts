import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {Note} from '../note';
import {NotesService} from '../notes.service';

@Component({
  selector: 'app-note-edit',
  templateUrl: './note-edit.component.html',
  styleUrls: ['./note-edit.component.css']
})
export class NoteEditComponent implements OnInit {

  note: Note;

  constructor(private route: ActivatedRoute,
              private noteService: NotesService,
              private router: Router) { }

  ngOnInit() {
    this.getNote();
  }

  getNote(): void {
    const id = +this.route.snapshot.paramMap.get('id');
    this.noteService.getNoteById(id)
      .subscribe(note => {
        this.note = note;
        this.note.MovieID = note.Movie.id;
      });
  }

  updateNote(): void {
    this.noteService.updateNoteById(this.note.id, this.note)
      .subscribe(note => {
        this.router.navigate(['/note']);
      });
  }

  onSubmit(submitted: boolean): void {
    if (submitted) {
      return this.updateNote();
    }
    return;
  }

}
