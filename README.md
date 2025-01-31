the ACTUAL exer1 is inside the molero folder.
since i'm preprocessing stuff to make my life easier, i have the rest of the files actually separate from the exer1 folder.

please install Git, WSL and Docker Desktop before running this command to clone the repository:

    git clone https://github.com/raffimolero/Exer1Spec.git
    cd Exer1Spec

After that, if you're on Windows:

- run the Docker Desktop application
- `./run`

If you're on Linux/Mac:

- `./run.sh`

This should automatically compile the Weird PHP into the Worses PHP and run the server.
Once it's done, simply follow the link printed in the terminal.

You can configure the port and the output filename in the `.env` file.
Currently, it has `PORT=8000` and `OUTNAME=targetname` so the link will be http://localhost:8000/targetname/index.php

i'm convinced this program is actual black magic. like, i haven't seen anything more arcane than this.

harry potter says expelliarmus. i say `Windows -> Batch -> Docker -> weird php -> worse php`. we are not the same.
