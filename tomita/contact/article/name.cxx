#encoding "utf8"
#GRAMMAR_ROOT ROOT

Begin -> AnyWord<wff="from|From|To|to|Кому|кому"> | AnyWord<wff="от|От"> AnyWord<wff="кого|Кого">{ weight=1 };
End -> AnyWord<wff="с|С"> AnyWord<wff="уважением|Уважением"> { weight=0.1 };

Name -> Word<gram="persn">;
Surname -> Word<gram="famn">;
Patronymic -> Word<gram="patrn">;

PersonRegexp -> Surname Name Patronymic | Surname Name | Name | Name Surname;
Person -> PersonRegexp<kwset=~[person]>;

Any -> AnyWord<gram="~persn, ~famn, ~patrn">;

ROOT -> End Any* Person interp (FactPerson.Name::not_norm) { weight=0 };
ROOT -> Begin Any* Person interp (FactPerson.Name::not_norm) { weight=1 };
