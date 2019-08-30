import { Component, OnInit } from '@angular/core';
import {Note} from '../note';
import {ActivatedRoute, Router} from '@angular/router';
import {NotesService} from '../notes.service';

@Component({
  selector: 'app-note-new',
  templateUrl: './note-new.component.html',
  styleUrls: ['./note-new.component.css']
})
export class NoteNewComponent implements OnInit {

  note: Note;

  constructor(private route: ActivatedRoute,
              private noteService: NotesService,
              private router: Router) { }

  ngOnInit() {
    this.note = new Note();
  }

  addNote(): void {
    this.noteService.addNote(this.note)
      .subscribe(note => {
        this.router.navigate(['/note']);
      });
  }

  onSubmit(submitted: boolean): void {
    if (submitted) {
      return this.addNote();
    }
    return;
  }

}
